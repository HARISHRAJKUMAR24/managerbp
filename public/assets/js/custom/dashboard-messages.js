// Dashboard Messages Management - Updated UI Version
$(document).ready(function () {
    const basePath = 'ajax/dashboard-messages/dashboard-messages.php';

    // Load messages on page load
    loadMessages();

    // Form submission
    $("#messageForm").on("submit", function (e) {
        e.preventDefault();

        const element = this;
        const submitBtn = $(element).find('button[type="submit"]');
        const indicatorLabel = submitBtn.find('.indicator-label');
        const indicatorProgress = submitBtn.find('.indicator-progress');

        // Show loading state
        indicatorLabel.addClass('d-none');
        indicatorProgress.removeClass('d-none');
        submitBtn.prop('disabled', true);

        const formData = new FormData(this);
        formData.append('request', 'create');

        $.ajax({
            url: basePath,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                try {
                    if (typeof data === 'string' && data.trim().startsWith('<')) {
                        console.error('Server returned HTML instead of JSON:', data.substring(0, 200));
                        toastr.error('Server error occurred. Please check console for details.', 'Error');
                        return;
                    }

                    const response = typeof data === 'object' ? data : JSON.parse(data);

                    if (response.type === 'success') {
                        toastr.success(response.msg, 'Success', {
                            timeOut: 3000,
                            progressBar: true
                        });
                        loadMessages();
                        element.reset();
                        $('select[name="seller_type[]"]').val(null).trigger('change');
                        $('#just_created_seller').prop('checked', false);
                    } else {
                        toastr.error(response.msg, 'Error', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    }

                } catch (e) {
                    console.error('Error parsing response:', e);
                    console.log('Raw response:', data);
                    toastr.error('Invalid response from server. Please check console.', 'Error');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                console.log('XHR response:', xhr.responseText);
                toastr.error('Network error occurred: ' + error, 'Error');
            },
            complete: function () {
                indicatorLabel.removeClass('d-none');
                indicatorProgress.addClass('d-none');
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Load messages function
    function loadMessages() {
        $.ajax({
            url: basePath,
            type: 'POST',
            data: { request: 'display' },
            success: function (data) {
                try {
                    if (typeof data === 'string' && data.trim().startsWith('<')) {
                        console.error('Server returned HTML instead of JSON:', data.substring(0, 200));
                        $('#messages_Table tbody').html('<tr><td colspan="6" class="text-center text-danger py-4">Server Error - Check Console</td></tr>');
                        return;
                    }

                    const response = typeof data === 'object' ? data : JSON.parse(data);

                    if (response.success && response.data) {
                        renderMessages(response.data);
                    } else {
                        console.error('Unexpected response format:', response);
                        $('#messages_Table tbody').html('<tr><td colspan="6" class="text-center text-muted py-4">No messages data found</td></tr>');
                    }
                } catch (e) {
                    console.error('Error parsing messages:', e);
                    console.log('Raw response:', data);
                    $('#messages_Table tbody').html('<tr><td colspan="6" class="text-center text-danger py-4">Error parsing messages - Check Console</td></tr>');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error loading messages:', error);
                console.log('XHR response:', xhr.responseText);
                $('#messages_Table tbody').html('<tr><td colspan="6" class="text-center text-danger py-4">Network Error - Failed to load messages</td></tr>');
            }
        });
    }

    // Render messages in table - UPDATED UI
    function renderMessages(messages) {
        const tbody = $('#messages_Table tbody');
        tbody.empty();

        if (!messages || messages.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="6" class="text-center py-8">
                        <div class="text-gray-500 fw-semibold fs-6">
                            <div class="text-gray-400 mb-2">📄</div>
                            <div>No messages found</div>
                        </div>
                    </td>
                </tr>
            `);
            return;
        }

        messages.forEach((message, index) => {
            const messageId = message.id;
            const title = message.title || '';
            const description = message.description || '';
            const sellerType = message.seller_type || 'All Sellers';
            const expiry = message.expiry || '';
            const status = message.status || 'Active';
            const isActive = status === 'Active';
            const targetBadge = message.target_badge || '';

            const row = `
                <tr class="border-bottom border-gray-200">
                    <td class="ps-4 align-middle">
                        <span class="text-gray-700 fw-bold">${index + 1}</span>
                    </td>
                    <td class="align-middle">
                        <div class="d-flex flex-column">
                            <div class="text-gray-800 fw-bold fs-6 mb-1 d-flex align-items-center">
                                <span class="me-2">${escapeHtml(title)}</span>
                                ${targetBadge}
                            </div>
                            <div class="text-gray-600 fs-7 line-clamp-2">${escapeHtml(description)}</div>
                        </div>
                    </td>
                    <td class="align-middle">
                        <span class="badge badge-light-primary fs-8 px-3 py-2">${escapeHtml(sellerType)}</span>
                    </td>
                    <td class="align-middle">
                        <div class="fw-semibold fs-7 text-center">${expiry}</div>
                    </td>
                    <td class="align-middle">
                        <span class="badge ${isActive ? 'badge-light-success' : 'badge-light-danger'} fs-8 px-3 py-2">
                            ${status}
                        </span>
                    </td>
                    <td class="text-end pe-4 align-middle">
                        <div class="d-flex justify-content-end">
                            ${isActive ?
                    `<button class="btn btn-sm btn-danger delete-btn" data-id="${messageId}">
                                    DELETE
                                </button>` :
                    `<button class="btn btn-sm btn-light" disabled>
                                    EXPIRED
                                </button>`
                }
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        // Remove any custom CSS styles since we're using Bootstrap classes
        removeCustomStyles();
    }

    // Remove custom CSS styles
    function removeCustomStyles() {
        if ($('#messages_TableStyles').length) {
            $('#messages_TableStyles').remove();
        }
    }

    // Simple HTML escape function
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Delete message
    $(document).on('click', '.delete-btn', function () {
        const messageId = $(this).data('id');
        const messageTitle = $(this).closest('tr').find('td:eq(1) .text-gray-800').text().trim();

        Swal.fire({
            title: 'Delete Message?',
            text: `Are you sure you want to delete "${messageTitle}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-light'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: basePath,
                    type: 'POST',
                    data: {
                        request: 'delete',
                        id: messageId
                    },
                    success: function (data) {
                        try {
                            if (typeof data === 'string' && data.trim().startsWith('<')) {
                                console.error('Server returned HTML instead of JSON:', data.substring(0, 200));
                                toastr.error('Server error occurred. Please check console.', 'Error');
                                return;
                            }

                            const response = typeof data === 'object' ? data : JSON.parse(data);

                            if (response.type === 'success') {
                                toastr.success(response.msg, 'Deleted', {
                                    timeOut: 3000,
                                    progressBar: true
                                });
                                loadMessages();
                            } else {
                                toastr.error(response.msg, 'Error');
                            }

                        } catch (e) {
                            console.error('Error parsing delete response:', e);
                            console.log('Raw response:', data);
                            toastr.error('Invalid response from server', 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error deleting message:', error);
                        toastr.error('An error occurred: ' + error, 'Error');
                    }
                });
            }
        });
    });

    // Initialize Select2 with better "All Sellers" handling
    $('select[name="seller_type[]"]').select2({
        placeholder: "Select seller types",
        allowClear: true,
        width: '100%',
        closeOnSelect: false,
        templateSelection: function (data) {
            // Show "All Sellers" when selected
            if (data.id === 'all') {
                return $('<span class="text-primary fw-bold">' + data.text + '</span>');
            }
            return data.text;
        }
    });

    // Handle Select2 change event for "All Sellers" - IMPROVED VERSION
    $('select[name="seller_type[]"]').on('change', function () {
        const selectedValues = $(this).val();

        // If "all" is selected and there are other values
        if (selectedValues && selectedValues.includes('all') && selectedValues.length > 1) {
            // Keep only "all" and remove others
            $(this).val(['all']).trigger('change');
        }

        // If nothing is selected, show placeholder
        if (!selectedValues || selectedValues.length === 0) {
            // Reset placeholder text
            $(this).next('.select2-container').find('.select2-selection__placeholder')
                .text('Select seller types');
        }
    });

    // Reset form
    $('button[type="reset"]').on('click', function () {
        $('#messageForm')[0].reset();
        $('select[name="seller_type[]"]').val(null).trigger('change');
        $('#just_created_seller').prop('checked', false);
    });

    // Search functionality
    $('#searchMessages').on('keyup', function () {
        const value = $(this).val().toLowerCase();
        $('#messages_Table tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Add CSS for better Select2 display
    if (!$('#select2-custom-styles').length) {
        $('head').append(`
            <style id="select2-custom-styles">
                .select2-selection--multiple .select2-selection__choice {
                    background-color: #f8f9fa !important;
                    border-color: #e4e6ef !important;
                    color: #5e6278 !important;
                    font-weight: 500 !important;
                }
                
                .select2-selection--multiple .select2-selection__choice[title="All Sellers"] {
                    background-color: #e8fff3 !important;
                    border-color: #1bc5bd !important;
                    color: #1bc5bd !important;
                    font-weight: 700 !important;
                }
                
                .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                    color: #a1a5b7 !important;
                }
                
                .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
                    color: #f1416c !important;
                }
            </style>
        `);
    }
});