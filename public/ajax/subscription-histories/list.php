<?php
header('Content-Type: application/json');
require_once '../../../src/database.php';

try {
    // Get DataTables parameters
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $offset = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    
    // Your custom filters
    $planId = isset($_POST['planFilter']) ? $_POST['planFilter'] : '';
    $gstStatus = isset($_POST['gstFilter']) ? $_POST['gstFilter'] : '';
    $paymentMethod = isset($_POST['paymentMethodFilter']) ? $_POST['paymentMethodFilter'] : '';
    $startDate = isset($_POST['startDateFilter']) ? $_POST['startDateFilter'] : '';
    $endDate = isset($_POST['endDateFilter']) ? $_POST['endDateFilter'] : '';
    
    // Prepare conditions
    $conditions = [];
    if (!empty($planId)) $conditions['plan_id'] = $planId;
    if (!empty($gstStatus)) $conditions['gst_status'] = $gstStatus;
    if (!empty($paymentMethod)) $conditions['payment_method'] = $paymentMethod;
    if (!empty($startDate)) $conditions['start_date'] = $startDate;
    if (!empty($endDate)) $conditions['end_date'] = $endDate;
    
    // Fetch data
    $histories = fetchSubscriptionHistories($limit, $offset, $searchValue, $conditions);
    
    // Get totals
    $totalRecords = getTotalSubscriptionHistoryRecords();
    $filteredRecords = getFilteredSubscriptionHistoryRecords($searchValue, $conditions);
    
    // Prepare data array
    $data = [];
    
    foreach ($histories as $row) {
        // Format amount with currency
        $amountFormatted = $row['currency_symbol'] . ' ' . number_format($row['amount'], 2);
        
        // Customer info with name, phone, email
        $customerName = $row['name'] ?? 'Unknown';
        $customerPhone = $row['phone'] ?? '';
        $customerEmail = $row['email'] ?? '';
        
        $customerInfo = '<div class="d-flex flex-column">' .
            '<span class="text-dark fw-bold">' . htmlspecialchars($customerName) . '</span>';
        
        if ($customerPhone) {
            $customerInfo .= '<span class="text-muted fs-7">' . htmlspecialchars($customerPhone) . '</span>';
        }
        if ($customerEmail) {
            $customerInfo .= '<span class="text-muted fs-7">' . htmlspecialchars($customerEmail) . '</span>';
        }
        
        $customerInfo .= '</div>';
        
        // Payment ID display (with tooltip)
        $paymentIdDisplay = $row['payment_id'] ?? '';
        if (!empty($paymentIdDisplay)) {
            if (strlen($paymentIdDisplay) > 20) {
                $shortPaymentId = substr($paymentIdDisplay, 0, 17) . '...';
                $paymentIdHtml = '<span class="text-muted" title="' . htmlspecialchars($paymentIdDisplay) . '">' . htmlspecialchars($shortPaymentId) . '</span>';
            } else {
                $paymentIdHtml = '<span class="text-muted">' . htmlspecialchars($paymentIdDisplay) . '</span>';
            }
        } else {
            $paymentIdHtml = '<span class="text-muted">N/A</span>';
        }
        
        $data[] = [
            "checkbox" => '<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" value="' . $row['id'] . '" /></div>',
            "invoice_number" => '<span class="text-dark fw-bold">#' . $row['invoice_number'] . '</span>',
            "plan_name" => $row['plan_name'] ?? 'N/A',
            "customer_info" => $customerInfo,
            "amount" => '<span class="text-dark fw-bold">' . $amountFormatted . '</span>',
            "payment_method" => '<span class="badge badge-light-primary fw-bold">' . ucfirst($row['payment_method']) . '</span>',
            "payment_id" => $paymentIdHtml
        ];
    }
    
    // Prepare response
    $response = [
        "draw" => $draw,
        "recordsTotal" => intval($totalRecords),
        "recordsFiltered" => intval($filteredRecords),
        "data" => $data
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode([
        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => [],
        "error" => "Database error occurred"
    ]);
}
exit();
?>