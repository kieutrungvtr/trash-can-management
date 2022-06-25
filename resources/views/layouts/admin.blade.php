<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="/statics/vendors/feather/feather.css">
    <link rel="stylesheet" href="/statics/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/statics/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/statics/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="/statics/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="/statics/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/statics/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/statics/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/statics/images/favicon.png">
    <style type="text/css">/* Chart.js */
        @keyframes chartjs-render-animation {
            from {
                opacity: .99
            }
            to {
                opacity: 1
            }
        }

        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms
        }

        .chartjs-size-monitor, .chartjs-size-monitor-expand, .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1
        }

        .chartjs-size-monitor-expand > div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0
        }

        .chartjs-size-monitor-shrink > div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0
        }</style>
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('layouts.admin-navbar')
    <div class="container-fluid page-body-wrapper pt-0">

        <!-- partial:partials/_sidebar.html -->
        @include('layouts.admin-sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>

            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Rác thải by Hậu và Trung</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2022</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="/statics/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="/statics/vendors/chart.js/Chart.min.js"></script>
<script src="/statics/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/statics/vendors/progressbar.js/progressbar.min.js"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="/statics/js/off-canvas.js"></script>
<script src="/statics/js/hoverable-collapse.js"></script>
<script src="/statics/js/template.js"></script>
<script src="/statics/js/settings.js"></script>
<script src="/statics/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/statics/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/statics/js/dashboard.js"></script>
<script src="/statics/js/Chart.roundedBarCharts.js"></script>
<!-- End custom js for this page-->
</body>
</html>
