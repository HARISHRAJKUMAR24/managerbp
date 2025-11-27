<!--begin:Header-->
<?php
require_once '../../src/functions.php';
renderTemplate('header');

$settings = fetchSettings();
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
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Subscription Plans</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Subscription Plans</h1>

                        <a href="subscription-plans/add" class="btn btn-sm btn-primary">Add Plan</a>
                    </div>
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
            <div class="row">

                <?php
                $data = fetchSubscriptionPlans();
                foreach ($data as $row):
                ?>

                    <div class="col-lg-3">
                        <div class="card border shadow-none">
                            <div class="card-body">
                                <h5 class="text-start text-uppercase mb-3"><?= $row['name'] ?></h5>

                                <div class="text-center position-relative mb-2 pb-1">
                                    <div class="mb-2 d-flex">

                                        <h1 class="price-toggle text-primary price-yearly mb-0 d-flex"><?= getCurrencySymbol($settings->currency) . $row['amount'] ?></h1>
                                        <sub class="h5 text-muted pricing-duration mt-auto mb-2">/<?= convertDays($row['duration']) ?></sub>
                                    </div>
                                </div>

                                <p><?= $row['description'] ?></p>

                                <hr>

                                <ul class="list-unstyled pt-2 pb-1">

                                    <?php foreach (explode(',', $row['feature_lists']) as $item): ?>
                                        <li class="mb-2">
                                            <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="ki-duotone ki-check-circle" style="font-size: 1.2rem;">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <?= $item ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <a href="subscription-plans/<?= $row['plan_id'] ?>" class="btn btn-info w-100">Update</a>
                                <button id="toggleIsDisabled" class="btn btn-<?= $row['is_disabled'] ? 'danger' : 'success' ?> w-100 mt-2" data-id="<?= $row['id'] ?>"><?= $row['is_disabled'] ? "Disabled" : "Enabled" ?></button>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
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
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="assets/js/custom/subscription-plans/list.js"></script>
<!--end::Custom Javascript-->