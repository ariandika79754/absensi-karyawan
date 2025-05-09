<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= (!empty($title) ? $title : 'Aplikasi E-RadarTV') ?></title>

    <meta name="description" content="" />
    <!-- Tambahkan di bagian head -->
    <link rel="stylesheet" type="text/css" href="/template/assets/datatables/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/template/assets/datatables/dataTables.bootstrap5.min.css">
    <style>
        .dataTables_wrapper {
            margin: 20px;
            /* Sesuaikan dengan kebutuhan Anda */
        }
    </style>
    <link href="/assets/img/favicon.png" rel="icon">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/template/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/template/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/template/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <!-- <link rel="stylesheet" href="/template/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" /> -->
    <link rel="stylesheet" href="/template/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/template/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Toastify -->
    <link rel="stylesheet" href="/template/assets/toastify/script.css">
    <link rel="stylesheet" href="/template/assets/toastify/toastify.css">


    <link rel="stylesheet" href="/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="/template/assets/select2/select2.css">

    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="/template/assets/bootstrap-select/bootstrap-select.min.css">
    <!-- Helpers -->
    <script src="/template/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/template/assets/js/config.js"></script>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/" class="app-brand-link">
                        <img src="/template/assets/img/logo/logo.png" width="30%">
                        <span class=" demo menu-text fw-bold ms-2">E-RadarTv</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-x bx-sm align-middle"></i> <!-- Ini ikon 'X' -->

                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                <?php $request = service('request'); ?>

                <?php if ($request->uri->getSegment(1) === 'admin') : ?>
                    <?= view('layout/sidebar_admin'); ?>
                <?php endif; ?>
                <?php if ($request->uri->getSegment(1) === 'karyawan') : ?>
                    <?= view('layout/sidebar_karyawan'); ?>
                <?php endif; ?>



            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <strong class="text">Selamat Datang di aplikasi E-RadarTV</strong>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->

                            <a href="/<?= strtolower(session()->get('role')); ?>/profil" data-icon="octicon-star" data-size="large" data-show-count="true">
                                <?= session()->get('data')['username']; ?>
                            </a>
                            &nbsp;

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">

                                        <img src="/template/assets/img/logo/defaultt.png" alt class="w-px-40 h-5 rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="/template/assets/img/logo/defaultt.png" alt class="w-px-40 h-5 rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block"><?= session()->get('data')['username']; ?></span>
                                                    <small class="text-muted"><?= session()->get('role'); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/<?= strtolower(session()->get('role')); ?>/profil">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <!-- <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li> -->

                                    <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/auth/logout">
                                    <i class="bx bx-log-out me-2"></i>
                                    <span class="align-middle">Log Out</span>
                                </a>
                            </li>

                        </ul>
                        </li>
                        <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">


                        <?= $this->renderSection('content') ?>


                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                E-RadarTV

                            </div>

                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.7.0.js"></script> -->


    <script src="/template/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/template/assets/vendor/libs/popper/popper.js"></script>
    <script src="/template/assets/vendor/js/bootstrap.js"></script>
    <script src="/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/template/assets/vendor/js/menu.js"></script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script type="text/javascript" charset="utf8" src="/template/assets/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/template/assets/datatables/dataTables.bootstrap5.min.js"></script>

    <script src="/template/assets/bootstrap-select/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function() {
            new DataTable('#example');
        });
        $(document).ready(function(e) {
            $('.selectpicker').selectpicker();
        });
        $(document).ready(function(e) {
            $('.selectpickerThAkademik').selectpicker();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
    </script>
    <script src="/template/assets/select2/select2.js"></script>

    <!-- Vendors JS -->
    <script src="/template/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/template/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/template/assets/js/dashboards-analytics.js"></script>

    <!-- Sweet Alert -->
    <script src="/template/assets/sweet-alert/sweetalert.min.js"></script>

    <script src="/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>



    <!-- Page JS -->
    <script src="/template/assets/js/extended-ui-perfect-scrollbar.js"></script>

    <!-- Toastify -->
    <script src="/template/assets/toastify/toastify-es.js"></script>
    <script src="/template/assets/toastify/toastify.js"></script>
    <script src="/template/assets/toastify/script.js"></script>
    <script>
        function getServerTime() {
            return fetch('<?= base_url('server') ?>')
                .then(response => response.json())
                .then(data => new Date(data.server_time));
        }

        function updateClock() {
            getServerTime().then(currentTime => {
                const hours = currentTime.getHours().toString().padStart(2, '0');
                const minutes = currentTime.getMinutes().toString().padStart(2, '0');
                const seconds = currentTime.getSeconds().toString().padStart(2, '0');
                const timeString = hours + ':' + minutes + ':' + seconds;
                document.getElementById('current-time').textContent = timeString;
            });
        }

        // Update the clock every second
        setInterval(updateClock, 1000);

        // Initial update
        updateClock();
    </script>

    <script>
        <?php if (session()->getFlashData('success')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('success') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#00FF7F'
                }
            }).showToast();

        <?php endif; ?>
        <?php if (session()->getFlashData('primary')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('primary') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#7B68EE'
                }
            }).showToast();

        <?php endif; ?>
        <?php if (session()->getFlashData('warning')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('warning') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#F4A460'
                }
            }).showToast();

        <?php endif; ?>
        <?php if (session()->getFlashData('error')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('error') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#FF4500'
                }
            }).showToast();

        <?php endif; ?>
    </script>


    <script src="/template/assets/js/myScript.js" type="text/javascript"></script>



    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>