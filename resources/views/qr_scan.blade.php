<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nâng cao nhận thức pháp luật và tăng cường sự phối hợp giữa các cơ quan nhà nước, các tổ chức, cộng đồng trong phân loại, lưu giữ, chuyển giao và thu gom chất thải rắn sinh hoạt</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
    <style>
        #scroll-container {
            overflow: hidden;
        }

        #scroll-text {
            font-size: 1.25em;
            word-break: keep-all;
            white-space: nowrap;
            /* animation properties */
            -moz-transform: translateX(100%);
            -webkit-transform: translateX(100%);
            transform: translateX(100%);

            -moz-animation: my-animation 15s linear infinite;
            -webkit-animation: my-animation 15s linear infinite;
            animation: my-animation 15s linear infinite;

        }
        #scroll-text:hover {
            animation-play-state: paused;
        }

        /* for Firefox */
        @-moz-keyframes my-animation {
            from { -moz-transform: translateX(100%); }
            to { -moz-transform: translateX(-200%); }
        }

        /* for Chrome */
        @-webkit-keyframes my-animation {
            from { -webkit-transform: translateX(100%); }
            to { -webkit-transform: translateX(-200%); }
        }

        @keyframes my-animation {
            from {
                -moz-transform: translateX(0%);
                -webkit-transform: translateX(0%);
                transform: translateX(0%);
            }
            to {
                -moz-transform: translateX(-200%);
                -webkit-transform: translateX(-200%);
                transform: translateX(-200%);
            }
        }
        .c_with {
            max-height: 250px;
            height: 40vw;
        }
        .breadcrumb-item {
            font-size: 1.2em !important;
            font-weight: bold !important;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: var(--bs-breadcrumb-divider, "->") !important;/* rtl: var(--bs-breadcrumb-divider, "/") */;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper pt-0">
        <div class="main-panel" style="width: 100%; height: 100vh; overflow: auto">
            <div class="content-wrapper d-flex">
                <div class="container m-auto">
                    <div class="d-flex justify-content-center">
                        <div class="card w-100">
                            <div class="card-header">
                                <div id="scroll-container">
                                    <div id="scroll-text">
                                        {{ __('Nâng cao nhận thức pháp luật và tăng cường sự phối hợp giữa các cơ quan nhà nước, các tổ chức, cộng đồng trong phân loại, lưu giữ, chuyển giao và thu gom chất thải rắn sinh hoạt') }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="carousel_logo" class="carousel slide" data-ride="carousel" data-interval="3000">
                                    <div class="carousel-inner">
                                        <div class="carousel-item text-center active">
                                            <img class="d-inline-block c_with" width="auto" src="/images/logo/lmca.png" alt="Liên minh châu âu">
                                        </div>
                                        <div class="carousel-item text-center">
                                            <img class="d-inline-block c_with" width="auto" src="/images/logo/eu_jule.png" alt="EU JULE">
                                        </div>
                                        <div class="carousel-item text-center">
                                            <img class="d-inline-block c_with" width="auto" src="/images/logo/oxfam.png" alt="OXFAM">
                                        </div>
                                        <div class="carousel-item text-center">
                                            <img class="d-inline-block c_with"  width="auto" src="/images/logo/ueh_university.png" alt="UEH">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel_logo" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Trước</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel_logo" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Sau</span>
                                    </a>
                                </div>

                                @if($trash->trash_qr ?? '')
                                <form action="/qr_scan" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="qr_code" style="display: none"></label>
                                        <input type="hidden" class="form-control" id="qr_code" name="qr_code"
                                               placeholder="CODE" required readonly
                                               value="{{$trash->trash_qr ?? ''}}"/>
                                    </div>
                                    <div class="form-group">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb p-0 m-0 border-0">
                                                <li class="breadcrumb-item">{{$trash_location_list[$trash->trash_location_index]["trash_location_name"]  }}</li>
                                                <li class="breadcrumb-item">{{$trash_group_list[$trash->trash_group_index]["trash_group_name"]  }}</li>
                                                <li class="breadcrumb-item active" aria-current="page">
                                                    <i class="mdi mdi-delete" style="color: {{$trash_type_list[$trash->trash_type_index]["trash_type_color"]}}"></i>
                                                    {{$trash_type_list[$trash->trash_type_index]["trash_type_name"]  }}
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                    <div class="form-group">
                                        <p style="font-size: 0.9rem"><strong>Ghi chú:</strong>
                                            {{$trash_type_list[$trash->trash_type_index]["trash_type_description"]}}
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_name">Tên<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" value="{{$user->user_name ?? ''}}" placeholder="Tên" required @if($user??'') readonly @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_phone">Số điện thoại</label>
                                        <input type="text" pattern="[0-9]{0,10}" class="form-control" id="user_phone" name="user_phone" value="{{$user->user_phone ?? ''}}" placeholder="Số điện thoại" @if($user??'') readonly @endif>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Giới tính</label>
                                        <div class="col">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="user_gender" id="user_gender" value="0" @if(($user->user_gender??0) == 0) checked="checked" @endif>
                                                    Không
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="user_gender" id="user_gender" value="1" @if(($user->user_gender??0) == 1) checked="checked" @endif>
                                                    Nam
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="user_gender" id="user_gender" value="2" @if(($user->user_gender??0) == 2) checked="checked" @endif>
                                                    Nữ
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="trash_info_weight">Khối lượng<span style="color: red">*</span></label>
                                        <select class="form-control" id="trash_info_weight" name="trash_info_weight" required>
                                            <option value="">Chọn khối lượng</option>
                                            @for($i = 1; $i <= 100; $i++)
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
                                        <br/><br/>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="/statics/js/jquery.cookie.js" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- End custom js for this page-->


<script>
    $(function () {
        var name = $.cookie("user_name");
        var gender = $.cookie("user_gender");
        var phone = $.cookie("user_phone");
        if(name !== undefined && name.length > 0) {
            if($('#user_name').val().length == 0) {
                $('#user_name').val(name);
                $('#user_gender').val(gender);
                $('#user_phone').val(phone);
                $('#user_name').attr("readonly", "readonly");
            }
        }
        if($('#user_name').val().length > 0) {
            $('#unlock_name').show();
        }
    })
    function unlockName() {
        $('#user_name').removeAttr("readonly");
        $('#user_phone').removeAttr("readonly");
        $('#unlock_name').hide();
    }
</script>
</body>
</html>
