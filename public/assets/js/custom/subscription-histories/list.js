$(document).ready(function () {
  var table = $("#kt_table").DataTable({
    processing: true,
    serverSide: true, // Enable server-side processing
    pageLength: 10, // Default number of records to display
    ordering: false,
    ajax: {
      url: `${BASE_URL}ajax/subscription-histories/list.php`,
      type: "POST",
      data: function (d) {
        d.search = $("#searchFilter").val();
      },
    },
    columns: [
      { data: "invoice_number" },
      { data: "user" },
      { data: "payment_method" },
      { data: "payment_id" },
      { data: "amount" },
    ],
  });
});
