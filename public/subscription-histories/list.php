<!--begin:Header-->
<?php
require_once '../../src/functions.php';
renderTemplate('header');

$settings = fetchSettings();
$subscription_histories = getAllSubscriptionHistories();

// Get unique plans for filter dropdown
$unique_plans = [];
foreach ($subscription_histories as $history) {
    if (!empty($history['plan_name']) && !in_array($history['plan_name'], array_column($unique_plans, 'name'))) {
        $unique_plans[] = [
            'id' => $history['plan_id'],
            'name' => $history['plan_name']
        ];
    }
}
?>
<!--end:Header-->

<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column gap-1 me-3 mb-2 w-100">
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            <a href="<?= BASE_URL ?>" class="text-gray-500">
                                <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Subscription Histories</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Subscription Histories</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Filters Card-->
            <div class="card mb-5">
                <div class="card-body">
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Plan Name</label>
                            <select name="plan_filter" class="form-select form-select-solid">
                                <option value="all">All Plans</option>
                                <?php foreach ($unique_plans as $plan): ?>
                                    <option value="<?= $plan['id'] ?>"><?= htmlspecialchars($plan['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">GST Status</label>
                            <select name="gst_filter" class="form-select form-select-solid">
                                <option value="all">All</option>
                                <option value="with_gst_number">GST Yes</option>
                                <option value="without_gst_number">GST No</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select form-select-solid">
                                <option value="all">All Methods</option>
                                <option value="razorpay">Razorpay</option>
                                <option value="phonepe">Phonepe</option>
                                <option value="payu">Payu</option>
                                <option value="manual">Manual</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date Range</label>
                            <div class="input-group input-group-solid">
                                <input type="date" name="date_from" class="form-control form-control-solid" placeholder="From">
                                <span class="input-group-text">to</span>
                                <input type="date" name="date_to" class="form-control form-control-solid" placeholder="To">
                            </div>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div class="d-flex gap-3">
                                <button type="button" id="resetFilters" class="btn btn-light">
                                    <i class="ki-duotone ki-refresh fs-3 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ki-duotone ki-filter fs-3 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Filters Card-->

            <!--begin::Subscription Histories Table-->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-row-bordered align-middle" id="historiesTable">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                    <th class="text-center">#</th>
                                    <th>INVOICE NO</th>
                                    <th>Plan Name</th>
                                    <th>Customer Name</th>
                                    <th class="text-center">GST</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Payment Method</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="historiesTableBody">
                                <?php if (empty($subscription_histories)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-10">
                                            <div class="text-gray-600">No subscription histories found.</div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($subscription_histories as $index => $history):
                                        $plan_id = $history['plan_id'] ?? 0;
                                        $plan_name = $history['plan_name'] ?? '';
                                        $gst_number = $history['gst_number'] ?? '';
                                        $payment_method = $history['payment_method'] ?? '';
                                        $name = $history['name'] ?? '';
                                        $invoice_number = $history['invoice_number'] ?? '';
                                        $amount = $history['amount'] ?? 0;
                                        $currency = $history['currency'] ?? 'INR';
                                        $created_at = $history['created_at'] ?? date('Y-m-d H:i:s');

                                        // Determine GST status - Yes only if GST number is provided
                                        $has_gst_number = !empty($gst_number) && trim($gst_number) !== '';
                                        $gst_status = $has_gst_number ? 'with_gst_number' : 'without_gst_number';

                                        // GST display - Simple Yes/No
                                        $gst_display = $has_gst_number
                                            ? '<span class="badge badge-success">Yes</span>'
                                            : '<span class="badge badge-light">No</span>';
                                    ?>
                                        <tr class="history-row"
                                            data-plan-id="<?= $plan_id ?>"
                                            data-gst-status="<?= $gst_status ?>"
                                            data-payment-method="<?= strtolower($payment_method) ?>"
                                            data-invoice="<?= $invoice_number ?>"
                                            data-name="<?= strtolower($name) ?>"
                                            data-date="<?= date('Y-m-d', strtotime($created_at)) ?>">
                                            <td class="text-center"><?= $index + 1 ?></td>
                                            <td>
                                                <span class="badge badge-light text-dark fw-bold">#<?= $invoice_number ?></span>
                                            </td>
                                            <td>
                                                <?php if ($plan_name): ?>
                                                    <span class="badge badge-info"><?= htmlspecialchars($plan_name) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?= htmlspecialchars($name) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?= $gst_display ?>
                                            </td>
                                            <td class="text-center fw-bold text-primary">
                                                <?= getCurrencySymbol($currency) . ' ' . number_format($amount, 2) ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-light text-capitalize"><?= htmlspecialchars($payment_method) ?></span>
                                            </td>
                                            <td>
                                                <?= date('d M Y', strtotime($created_at)) ?>
                                                <small class="d-block text-muted"><?= date('h:i A', strtotime($created_at)) ?></small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Subscription Histories Table-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->

<!--include:Footer-->
<?php renderTemplate('footer'); ?>
<!--end:Footer-->

<!--begin::Vendors Javascript(used for this page only)-->
<script src="assets/plugins/custom/jquery/jquery-3.7.1.min.js"></script>
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(used for this page only)-->
<script src="assets/js/custom/subscription-histories/list.js"></script>
<!--end::Custom Javascript-->