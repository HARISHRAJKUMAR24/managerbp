<?php
header('Content-Type: application/json');

require_once '../../../src/database.php';

$limit = isset($_POST['length']) ? (int)$_POST['length'] : 10;
$offset = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$searchValue = isset($_POST['search']) ? $_POST['search'] : '';

// Fetch data
$histories = fetchSubscriptionHistories($limit, $offset, $searchValue);
$totalRecords = getTotalSubscriptionHistories();

$data = array();

foreach ($histories as $row) {
    $user = fetchUserById($row['user_id']);

    $data[] = [
        'invoice_number' => '#' . $row['invoice_number'],
        'user' => '<div class="d-flex align-items-center"><!--begin:: Avatar -->
        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
            <a href="#">
                <div class="symbol-label">
                    <img src="' . UPLOADS_URL . $user->image . '" alt="' . $user->name . '" class="w-100" />
                </div>
            </a>
        </div>
        <!--end::Avatar-->
        <!--begin::User details-->
        <div class="d-flex flex-column">
            <a href="#" class="text-gray-800 text-hover-primary mb-1">' . $user->name . '</a>
            <span>' . $user->email . '</span>
        </div>
        <!--begin::User details--></div>',
        'payment_method' => $row['payment_method'],
        'payment_id' => $row['payment_id'],
        'amount' => $row['amount'],
    ];
}

// Prepare response
$response = [
    "draw" => intval($_POST['draw'] ?? 1),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords, // Adjust this if you implement filtering
    "data" => $data
];

// Return JSON response
echo json_encode($response);
