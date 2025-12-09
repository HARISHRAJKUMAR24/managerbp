$(document).ready(function () {
  // Initialize DataTable
  const table = $('#historiesTable').DataTable({
    pageLength: 10,
    order: [[11, 'desc']], // Sort by date descending
    dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
    language: {
      search: "Search:",
      lengthMenu: "Show _MENU_ entries",
      info: "Showing _START_ to _END_ of _TOTAL_ entries",
    }
  });

  // Apply filters
  $('#filterForm').on('submit', function (e) {
    e.preventDefault();
    applyFilters();
  });

  // Search functionality
  $('#searchButton').on('click', function () {
    applyFilters();
  });

  $('#searchInput').on('keyup', function (e) {
    if (e.key === 'Enter') {
      applyFilters();
    }
  });

  function applyFilters() {
    const planFilter = $('select[name="plan_filter"]').val();
    const gstFilter = $('select[name="gst_filter"]').val();
    const paymentMethod = $('select[name="payment_method"]').val();
    const dateFrom = $('input[name="date_from"]').val();
    const dateTo = $('input[name="date_to"]').val();
    const searchTerm = $('#searchInput').val().toLowerCase();

    // Custom filtering function
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
      const row = table.row(dataIndex).node();
      const rowPlanId = $(row).data('plan-id');
      const rowGstStatus = $(row).data('gst-status');
      const rowPaymentMethod = $(row).data('payment-method');
      const rowInvoice = $(row).data('invoice').toString();
      const rowName = $(row).data('name');
      const rowEmail = $(row).data('email');
      const rowDate = $(row).data('date');

      // Plan filter
      if (planFilter !== 'all' && rowPlanId != planFilter) {
        return false;
      }

      // GST filter
      if (gstFilter !== 'all' && rowGstStatus !== gstFilter) {
        return false;
      }

      // Payment method filter
      if (paymentMethod !== 'all' && rowPaymentMethod !== paymentMethod) {
        return false;
      }

      // Date filter
      if (dateFrom && rowDate < dateFrom) {
        return false;
      }
      if (dateTo && rowDate > dateTo) {
        return false;
      }

      // Search filter
      if (searchTerm) {
        const searchInInvoice = rowInvoice.includes(searchTerm);
        const searchInName = rowName.includes(searchTerm);
        const searchInEmail = rowEmail.includes(searchTerm);

        if (!searchInInvoice && !searchInName && !searchInEmail) {
          return false;
        }
      }

      return true;
    });

    table.draw();

    // Remove the custom filter function after drawing
    $.fn.dataTable.ext.search.pop();
  }

  // Reset filters
  $('#resetFilters').on('click', function () {
    $('#filterForm')[0].reset();
    $('#searchInput').val('');
    table.search('').columns().search('').draw();
  });

  // View details
  $(document).on('click', '.view-details', function () {
    const historyId = $(this).data('id');

    $.ajax({
      url: BASE_URL + 'ajax/subscription-histories/list.php',
      type: 'POST',
      data: { id: historyId },
      beforeSend: function () {
        $('#detailsContent').html(`
                    <div class="text-center py-10">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3">Loading details...</p>
                    </div>
                `);
      },
      success: function (response) {
        $('#detailsContent').html(response);
        $('#viewDetailsModal').modal('show');
      },
      error: function () {
        $('#detailsContent').html(`
                    <div class="text-center py-10">
                        <div class="alert alert-danger">
                            <i class="ki-duotone ki-cross-circle fs-2x me-2"></i>
                            Error loading details!
                        </div>
                    </div>
                `);
        $('#viewDetailsModal').modal('show');
      }
    });
  });

  // Print invoice
  $(document).on('click', '#printInvoice', function () {
    const modalContent = $('#detailsContent').html();
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Invoice Print</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    .text-center { text-align: center; }
                    .fw-bold { font-weight: bold; }
                    .mt-3 { margin-top: 15px; }
                </style>
            </head>
            <body>
                <h2>Subscription Invoice</h2>
                ${modalContent}
                <div class="mt-3">
                    <p>Printed on: ${new Date().toLocaleString()}</p>
                </div>
            </body>
            </html>
        `);
    printWindow.document.close();
    printWindow.print();
  });
});