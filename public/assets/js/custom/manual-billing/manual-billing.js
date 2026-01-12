$(document).ready(function () {
    console.log('Manual Billing JS loaded');

    // Initialize variables
    let plans = [];
    let sellers = [];
    let paymentMethods = [];
    let currencies = [];
    let defaultCurrency = 'INR';
    let pincodeDebounceTimer = null;

    // Enhanced alert function
    function showAlert(type, message, details = '') {
        $('.custom-alert').remove();

        const alertClass = {
            success: 'alert-success',
            error: 'alert-danger',
            warning: 'alert-warning',
            info: 'alert-info'
        };

        const icon = {
            success: '✓',
            error: '✗',
            warning: '⚠',
            info: 'ℹ'
        };

        let alertContent = `
            <div class="custom-alert alert ${alertClass[type]} alert-dismissible fade show position-fixed" 
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <div class="d-flex align-items-center">
                    <span class="fs-4 me-3">${icon[type]}</span>
                    <div>
                        <strong>${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                        <div class="mt-1">${message}</div>
        `;

        if (details) {
            alertContent += `<small class="d-block mt-2 opacity-75">${details}</small>`;
        }

        alertContent += `
                    </div>
                </div>
            </div>
        `;

        const alert = $(alertContent);
        $('body').append(alert);

        setTimeout(() => {
            alert.alert('close');
        }, type === 'success' ? 5000 : 8000);
    }

    // Load data from server
    function loadData() {
        console.log('Loading data...');

        $.ajax({
            url: BASE_URL + 'ajax/manual-billing/get.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    plans = response.data.plans || [];
                    sellers = response.data.sellers || [];
                    paymentMethods = response.data.payment_methods || [];
                    currencies = response.data.currencies || [];
                    defaultCurrency = response.data.default_currency || 'INR';

                    console.log(`Loaded ${plans.length} plans, ${sellers.length} sellers`);

                    if (plans.length === 0) {
                        showAlert('warning', 'No active plans found in database');
                    }

                    if (sellers.length === 0) {
                        showAlert('warning', 'No active sellers found in database');
                    }

                    populateDropdowns();
                    setupEventListeners();
                    initializeSelect2();

                    if (plans.length > 0 && sellers.length > 0) {
                        showAlert('success', 'Data loaded successfully');
                    }
                } else {
                    showAlert('error', 'Failed to load data', response.error);
                    // Removed fallback data loading
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                showAlert('error', 'Connection failed', 'Cannot connect to server');
                // Removed fallback data loading
            }
        });
    }

    // Populate dropdowns
    function populateDropdowns() {
        console.log('Populating dropdowns...');

        // Populate plans dropdown
        const $planSelect = $('select[name="plan_id"]');
        $planSelect.empty();
        $planSelect.append('<option value="">Select Plan</option>');

        if (plans.length === 0) {
            $planSelect.append('<option value="" disabled>No plans available</option>');
        } else {
            plans.forEach(plan => {
                const durationMonths = Math.floor(plan.duration / 30);
                $planSelect.append(`
                    <option value="${plan.id}" 
                            data-amount="${plan.amount}" 
                            data-duration-months="${durationMonths}">
                        ${plan.name} - ₹${plan.amount} for ${durationMonths} months
                    </option>
                `);
            });
        }

        // Populate sellers dropdown (basic for Select2)
        const $sellerSelect = $('#sellerSelect');
        $sellerSelect.empty();
        $sellerSelect.append('<option value="">Select Seller</option>');

        if (sellers.length === 0) {
            $sellerSelect.append('<option value="" disabled>No sellers available</option>');
        } else {
            sellers.forEach(seller => {
                $sellerSelect.append(`
                    <option value="${seller.id}"
                            data-name="${seller.name || ''}"
                            data-email="${seller.email || ''}"
                            data-mobile="${seller.mobile || ''}"
                            data-state="${seller.state || ''}"
                            data-city="${seller.city || ''}"
                            data-pincode="${seller.pincode || ''}"
                            data-address1="${seller.address_1 || ''}"
                            data-address2="${seller.address_2 || ''}">
                        ${seller.id} - ${seller.name} (${seller.site_name || 'No Site'})
                    </option>
                `);
            });
        }

        // Populate payment methods
        const $paymentSelect = $('select[name="payment_method"]');
        $paymentSelect.empty();
        $paymentSelect.append('<option value="">Select Payment Method</option>');
        paymentMethods.forEach(method => {
            $paymentSelect.append(`<option value="${method.value}">${method.label}</option>`);
        });

        // Populate currencies
        const $currencySelect = $('select[name="currency"]');
        $currencySelect.empty();
        $currencySelect.append('<option value="">Select Currency</option>');
        currencies.forEach(currency => {
            const selected = currency.code === defaultCurrency ? 'selected' : '';
            $currencySelect.append(`
                <option value="${currency.code}" ${selected}>
                    ${currency.code} - ${currency.name}
                </option>
            `);
        });

        $('#currencyDisplay').text(defaultCurrency);

        console.log('Dropdowns populated');
    }

    // Initialize Select2 for seller dropdown
    function initializeSelect2() {
        $('#sellerSelect').select2({
            placeholder: "Select a seller",
            allowClear: true,
            width: '100%',
            templateResult: formatSellerOption,
            templateSelection: formatSellerSelection,
            escapeMarkup: function (m) { return m; }
        });
    }

    // Format seller option in dropdown
    function formatSellerOption(seller) {
        if (!seller.id) return seller.text;

        const $option = $(seller.element);
        const sellerId = $option.val();
        const sellerName = $option.data('name') || '';
        const sellerEmail = $option.data('email') || '';
        const sellerMobile = $option.data('mobile') || '';
        const sellerSite = $option.text().match(/\(([^)]+)\)/)?.[1] || 'No Site';

        return $(`
            <div>
                <strong>${sellerId} - ${sellerName}</strong>
                <div class="small text-muted">
                    Site: ${sellerSite} | Email: ${sellerEmail} | Mobile: ${sellerMobile}
                </div>
            </div>
        `);
    }

    // Format selected seller
    function formatSellerSelection(seller) {
        if (!seller.id) return seller.text;

        const $option = $(seller.element);
        const sellerId = $option.val();
        const sellerName = $option.data('name') || '';

        return `${sellerId} - ${sellerName}`;
    }

    // Get address from pincode API
    function getAddressFromPincode(pincode) {
        if (!pincode || pincode.length !== 6) {
            return;
        }

        // Show loading indicator
        const $pincodeInput = $('input[name="pincode"]');
        const originalBorder = $pincodeInput.css('border-color');
        $pincodeInput.css('border-color', '#009ef7');

        $.ajax({
            url: `https://api.postalpincode.in/pincode/${pincode}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response[0] && response[0].Status === "Success") {
                    const postOffice = response[0].PostOffice[0];

                    // Fill the address fields
                    $('input[name="state"]').val(postOffice.State);
                    $('input[name="city"]').val(postOffice.District);
                    $('input[name="address_1"]').val(postOffice.Name + ', ' + postOffice.Block);

                    showAlert('success', 'Address fetched successfully');
                } else {
                    showAlert('warning', 'No address found for this pincode');
                }
                $pincodeInput.css('border-color', originalBorder);
            },
            error: function (xhr, status, error) {
                console.error('Pincode API Error:', error);
                showAlert('error', 'Failed to fetch address. Please enter manually.');
                $pincodeInput.css('border-color', originalBorder);
            }
        });
    }

    // Setup event listeners
    function setupEventListeners() {
        // Plan selection
        $('select[name="plan_id"]').on('change', function () {
            const selected = $(this).find('option:selected');
            const amount = selected.data('amount');
            const durationMonths = selected.data('duration-months');

            if (amount) $('input[name="amount"]').val(amount);
            if (durationMonths) {
                // Set duration based on months
                if (durationMonths >= 12) {
                    $('input[name="duration_value"]').val(Math.floor(durationMonths / 12));
                    $('select[name="duration_type"]').val('year');
                } else {
                    $('input[name="duration_value"]').val(durationMonths);
                    $('select[name="duration_type"]').val('month');
                }
            }
        });

        // Seller selection (using Select2 change event)
        $('#sellerSelect').on('change', function () {
            const selected = $(this).find('option:selected');

            if (selected.val()) {
                $('input[name="customer_name"]').val(selected.data('name') || '');
                $('input[name="customer_email"]').val(selected.data('email') || '');
                $('input[name="customer_mobile"]').val(selected.data('mobile') || '');
                $('input[name="state"]').val(selected.data('state') || '');
                $('input[name="city"]').val(selected.data('city') || '');
                $('input[name="pincode"]').val(selected.data('pincode') || '');
                $('input[name="address_1"]').val(selected.data('address1') || '');
                $('input[name="address_2"]').val(selected.data('address2') || '');
            }
        });

        // Pincode change with debounce
        $('input[name="pincode"]').on('input', function () {
            const pincode = $(this).val().trim();

            // Clear previous timer
            clearTimeout(pincodeDebounceTimer);

            // Only fetch if pincode is 6 digits
            if (pincode.length === 6 && /^\d+$/.test(pincode)) {
                // Debounce to avoid too many API calls
                pincodeDebounceTimer = setTimeout(() => {
                    // Check if state and city are empty before fetching
                    const currentState = $('input[name="state"]').val();
                    const currentCity = $('input[name="city"]').val();

                    if (!currentState && !currentCity) {
                        getAddressFromPincode(pincode);
                    } else {
                        // Ask user if they want to override
                        if (confirm('Address fields already filled. Do you want to fetch from pincode?')) {
                            getAddressFromPincode(pincode);
                        }
                    }
                }, 800); // 800ms debounce
            }
        });

        // Pincode on blur (when user leaves the field)
        $('input[name="pincode"]').on('blur', function () {
            const pincode = $(this).val().trim();

            if (pincode.length === 6 && /^\d+$/.test(pincode)) {
                // Check if address fields are empty
                const state = $('input[name="state"]').val();
                const city = $('input[name="city"]').val();
                const address1 = $('input[name="address_1"]').val();

                if (!state && !city && !address1) {
                    getAddressFromPincode(pincode);
                }
            }
        });

        // Currency change
        $('select[name="currency"]').on('change', function () {
            $('#currencyDisplay').text($(this).val() || defaultCurrency);
        });

        // Form submission
        $('#manualBillingForm').on('submit', function (e) {
            e.preventDefault();
            submitForm();
        });

        // Clear address when pincode is cleared
        $('input[name="pincode"]').on('change', function () {
            if ($(this).val().trim() === '') {
                $('input[name="state"]').val('');
                $('input[name="city"]').val('');
                $('input[name="address_1"]').val('');
            }
        });
    }

    // Submit form
    function submitForm() {
        const formData = {
            plan_id: $('select[name="plan_id"]').val(),
            seller_id: $('#sellerSelect').val(),
            amount: $('input[name="amount"]').val(),
            duration_value: $('input[name="duration_value"]').val(),
            duration_type: $('select[name="duration_type"]').val(),
            payment_method: $('select[name="payment_method"]').val(),
            payment_id: $('input[name="payment_id"]').val(),
            customer_name: $('input[name="customer_name"]').val(),
            customer_email: $('input[name="customer_email"]').val(),
            customer_mobile: $('input[name="customer_mobile"]').val(),
            state: $('input[name="state"]').val(),
            city: $('input[name="city"]').val(),
            pincode: $('input[name="pincode"]').val(),
            address_1: $('input[name="address_1"]').val(),
            address_2: $('input[name="address_2"]').val(),
            currency: $('select[name="currency"]').val(),
            country_code: $('select[name="country_code"]').val(),
            notes: $('textarea[name="notes"]').val()
        };

        // Validation
        const required = ['plan_id', 'seller_id', 'amount', 'duration_value', 'duration_type', 'payment_method',
            'customer_name', 'customer_email', 'customer_mobile', 'state',
            'city', 'pincode', 'address_1', 'currency', 'country_code'];

        for (const field of required) {
            if (!formData[field]) {
                const fieldName = field.replace(/_/g, ' ');
                showAlert('error', `Please fill in: ${fieldName}`);
                $(`[name="${field}"]`).focus();
                return;
            }
        }

        // Validate pincode length
        if (formData.pincode.length !== 6) {
            showAlert('error', 'Pincode must be 6 digits');
            $('input[name="pincode"]').focus();
            return;
        }

        // Show loading
        const $btn = $('#submitBtn');
        $btn.prop('disabled', true);
        $btn.find('.indicator-label').hide();
        $btn.find('.indicator-progress').show();

        // Submit
        $.ajax({
            url: BASE_URL + 'ajax/manual-billing/add.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                $btn.prop('disabled', false);
                $btn.find('.indicator-label').show();
                $btn.find('.indicator-progress').hide();

                if (response.success) {
                    showAlert('success', response.message);
                    resetForm();
                } else {
                    showAlert('error', response.message || 'Failed to create billing');
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false);
                $btn.find('.indicator-label').show();
                $btn.find('.indicator-progress').hide();
                showAlert('error', 'Network error');
            }
        });
    }
    // ===============================
    // Browser OCR using Tesseract.js
    // Razorpay + UPI Support
    // ===============================
    $('#transactionImage').on('change', async function () {
        const file = this.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            showAlert('error', 'Invalid file', 'Upload an image only');
            return;
        }

        showAlert('info', 'Processing screenshot...', 'Reading payment details');

        try {
            const { data: { text } } = await Tesseract.recognize(
                file,
                'eng',
                {
                    logger: m => console.log(m)
                }
            );

            console.log('OCR RAW TEXT:', text);

            const paymentId = extractPaymentId(text);

            if (paymentId) {
                $('input[name="payment_id"]').val(paymentId);
                showAlert('success', 'Payment ID detected', paymentId);
            } else {
                showAlert('warning', 'Payment ID not found', 'Please enter manually');
            }

        } catch (error) {
            console.error(error);
            showAlert('error', 'OCR failed', 'Unable to read screenshot');
        }
    });

    // ===============================
    // Extract Razorpay / UPI IDs
    // ===============================
    function extractPaymentId(text) {

        const patterns = [
            /pay_[A-Za-z0-9]+/,            // Razorpay
            /\b[a-f0-9]{32}\b/i,           // PhonePe (32-char hex)
            /UTR[:\s]*([A-Z0-9]+)/i,       // UPI UTR
            /Transaction\s*ID[:\s]*([A-Z0-9]+)/i,
            /Payment\s*ID[:\s]*([A-Z0-9_]+)/i,
            /\b[A-Z0-9]{12,20}\b/          // Generic fallback
        ];

        for (let pattern of patterns) {
            const match = text.match(pattern);
            if (match) {
                return match[1] || match[0];
            }
        }

        return null;
    }

    // Reset form
    window.resetForm = function () {
        $('#manualBillingForm')[0].reset();
        $('select[name="plan_id"], select[name="payment_method"]')
            .prop('selectedIndex', 0);
        $('#sellerSelect').val('').trigger('change');
        $('select[name="currency"]').val(defaultCurrency);
        $('select[name="country_code"]').val('IN');
        $('select[name="duration_type"]').val('year');
        $('#currencyDisplay').text(defaultCurrency);
        showAlert('info', 'Form reset');
    }

    // Start
    console.log('Starting manual billing...');
    loadData();
});