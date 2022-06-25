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
    <div class="container-fluid page-body-wrapper pt-0">
        <div class="main-panel" style="width: 100%; height: 100vh">
            <div class="content-wrapper d-flex">
                <div class="container m-auto">
                    <div class="d-flex justify-content-center">
                        <div class="card w-100">
                            <div class="card-header">{{ __('Nhập Liệu') }}</div>
                            <div class="card-body">
                                @if($trash->trash_qr ?? '')
                                <form action="/qr_scan" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="qr_code" style="display: none"></label>
                                        <input type="text" class="form-control" id="qr_code" name="qr_code"
                                               placeholder="CODE" required readonly
                                               value="{{$trash->trash_qr ?? ''}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_name">Tên</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Tên" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="trash_info_weight">Khối lượng</label>
                                        <select class="form-control" id="trash_info_weight" name="trash_info_weight">
                                            @for($i = 1; $i <= 40; $i++)
                                                <option value="{{$i*0.5}}">
                                                    {{$i*0.5}}kg
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary w-100">NHẬP LIỆU</button>
                                    </div>
                                    @if(session("success"))
                                        <span class="text-success"><strong>Thành công!</strong></span>
                                    @endif

                                    <div class="form-group" id="unlock_name" style="display: none">
                                        <button type="button" class="btn btn-secondary w-100" onclick="unlockName()">THAY ĐỔI TÊN</button>
                                    </div>
                                </form>
                                @else
                                    <h3 class="text-danger">QR Không tồn tại!!</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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


<script>
    $(function () {
        var name = $.cookie("user_name");
        if(name !== undefined && name.length > 0) {
            $('#unlock_name').show();
            $('#user_name').val(name);
            $('#user_name').attr("readonly", "readonly");
        }
    })
    function unlockName() {
        $('#user_name').removeAttr("readonly");
        $('#unlock_name').hide();
    }
</script>
</body>
</html>
