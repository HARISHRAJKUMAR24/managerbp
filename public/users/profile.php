<!--begin:Header-->
<?php
require_once '../../src/database.php';
require_once '../../src/functions.php';

if (!isset($_GET['id']) || !isUserExists($_GET['id'])) {
    redirect(BASE_URL . 'users');
}

$user = fetchUserById($_GET['id'], "user_id");

renderTemplate('header');

?>
<!--end:Header-->

<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->

<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            <a href="<?= BASE_URL ?>" class="text-gray-500 text-hover-primary">
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
                        <li class="breadcrumb-item text-gray-800 fw-bold lh-1">
                            <a href="<?= BASE_URL ?>users" class="text-gray-800 text-hover-primary">Users</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">ID : <?= $user->user_id ?></li>
                        <!--end::Item-->
                    </ul>

                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">User Profile</h1>
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
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xxl-8">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="<?= UPLOADS_URL . $user->image ?>" alt="<?= $user->name ?>" onerror="this.src='assets/media/avatars/blank.png'" />
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= htmlspecialchars($user->name) ?></a>
                                        <?php if (!$user->is_suspended): ?>
                                            <a href="#">
                                                <i class="ki-duotone ki-verify fs-1 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <?php if ($user->phone): ?>
                                            <a href="tel:<?= $user->phone ?>" class="d-flex align-items-center text-gray-800 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-phone fs-4 me-1 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i><?= htmlspecialchars($user->phone) ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (isset($user->country) && $user->country): ?>
                                            <a href="#" class="d-flex align-items-center text-gray-800 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-geolocation fs-4 me-1 text-success">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i><?= htmlspecialchars($user->country) ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($user->email): ?>
                                            <a href="mailto:<?= $user->email ?>" class="d-flex align-items-center text-gray-800 text-hover-primary mb-2">
                                                <i class="ki-duotone ki-sms fs-4 me-1 text-info">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i><?= htmlspecialchars($user->email) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->

                                <!--begin::Actions-->
                                <div class="d-flex my-4">
                                    <a class="btn btn-sm btn-primary me-2">Login</a>
                                    <?php if ($user->is_suspended): ?>
                                        <span class="btn btn-sm btn-danger">Suspended</span>
                                    <?php endif; ?>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?= getUserEarnings($user->id) ?>" data-kt-countup-prefix="<?= $user->currency ?> ">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-600">Earnings</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?= getUserAppointments($user->id) ?>">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-600">Appointments</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold text-gray-800">
                                                    <?= date('M d, Y', strtotime($user->created_at)) ?>
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-600">Joined Date</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->

                    <!--begin::Additional Info-->
                    <div class="d-flex flex-wrap gap-5 mt-7 pb-5">
                        <?php if ($user->user_id): ?>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-gray-600 fs-7">Customer ID</span>
                                <span class="fw-bold text-gray-800 fs-6"><?= htmlspecialchars($user->user_id) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($user->site_name): ?>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-gray-600 fs-7">Site Name</span>
                                <span class="fw-bold text-gray-800 fs-6"><?= htmlspecialchars($user->site_name) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($user->site_slug): ?>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-gray-600 fs-7">Site Slug</span>
                                <span class="fw-bold text-gray-800 fs-6"><?= htmlspecialchars($user->site_slug) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($user->expires_on): ?>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-gray-500 fs-7">Expires On</span>
                                <span class="fw-bold text-gray-800 fs-6"><?= date('M d, Y', strtotime($user->expires_on)) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($user->country) && $user->country): ?>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-gray-500 fs-7">Country</span>
                                <span class="fw-bold text-gray-800 fs-6"><?= htmlspecialchars($user->country) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!--end::Additional Info-->
                </div>
            </div>
            <!--end::Navbar-->
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
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->