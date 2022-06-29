@extends('layouts.admin')

@section('page_title')
    {{__('Tổng hợp')}}
@endsection
@section('page_message')
    {{__('Tổng hợp dữ liệu')}}
@endsection
@section('custom-style')
    <style>
        .home-tab .nav-tabs .nav-item .nav-link.active {
            background-color: white;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom"></div>
            </div>
            <div class="row row-cols-auto">
                <div class="card card-rounded col m-3 shadow-sm">
                    <div class="card-body pb-0">
                        <h4 class="card-title card-title-dash mb-4">Loại rác có khối lượng lớn nhất</h4>
                        <div class="row">
                            <div class="col">
                                <p class="status-summary-light-white mb-1">{{number_format($max_trash_type_kg??0, 2)}}kg</p>
                                <h2 class="text-black">{{$trash_type_list[$max_trash_type_id]['trash_type_name']??'Chưa xác định'}}</h2>
                                <br/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col m-3 ">
                    <a href="/admin/stats/export" target="_blank" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Xuất dữ liệu</a>
                </div>
            </div>
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="report_day_tab" data-bs-toggle="tab" href="#report_type_day" role="tab" aria-controls="report_day" aria-selected="true">
                                Tổng khối lượng loại rác trong ngày
                            </a>
                        </li><li class="nav-item">
                            <a class="nav-link" id="report_day_tab" data-bs-toggle="tab" href="#report_day" role="tab" aria-controls="report_day">
                                Trung bình một ngày/tuần thải ra bao nhiêu rác
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="report_user_tab" data-bs-toggle="tab" href="#report_user_type" role="tab" aria-controls="report_day">
                                Người đổ rác nhiều nhất
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="report_type_day" role="tabpanel" aria-labelledby="report_day">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Trung bình một ngày</h4>

                                        <form action="{{Request::url()}}">
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label for="from">Tù ngày</label>
                                                    <input type="date" id="from" name="from" value="{{$from}}" class="form-control"/>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="to">Đến ngày</label>
                                                    <input type="date" id="to" name="to" value="{{$to}}" class="form-control"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <label style="visibility: hidden">Submit</label><br>
                                                    <button type="submit" class="btn btn-primary text-white me-2 mb-0">Tìm kiếm</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Tên loại rác</th>
                                                    @foreach($date_totals_list??[] as $date)
                                                        <th>{{date("d/m/Y", strtotime($date))}}</th>
                                                    @endforeach
                                                </tr>
                                                @foreach($trash_type_list as $trash_type)
                                                    <tr>
                                                    <td>{{$trash_type['trash_type_name']}}</td>
                                                    @foreach($date_totals_list??[] as $date)
                                                        <td>{{number_format($date_totals[$date][$trash_type['trash_type_id']]??0, 2)}}kg</td>
                                                    @endforeach
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="report_day" role="tabpanel" aria-labelledby="report_day">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3>Trung bình một ngày</h3>
                                <div class="statistics-details d-flex align-items-center justify-content-between row row-cols-auto">
                                    @foreach($trash_type_list as $trash_type)
                                        <div class="col flex-fill m-3 card p-4" style="border: 4px {{App\Http\Controllers\Admin\StatisticsController::ConvertColorName($trash_type['trash_type_color'])}}7d solid">
                                            <p class="statistics-title">{{$trash_type['trash_type_name']}}</p>
                                            <h3 class="rate-percentage">{{number_format($avg_day_type_report[$trash_type['trash_type_id']] ?? 0, 2)}}kg</h3>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3>Trung bình một tuần</h3>
                                <div class="statistics-details d-flex align-items-center justify-content-between row row-cols-auto">
                                    @foreach($trash_type_list as $trash_type)
                                        <div class="col flex-fill m-3 card p-4" style="border: 4px {{App\Http\Controllers\Admin\StatisticsController::ConvertColorName($trash_type['trash_type_color'])}}7d solid">
                                            <p class="statistics-title">{{$trash_type['trash_type_name']}}</p>
                                            <h3 class="rate-percentage">{{number_format($avg_week_type_report[$trash_type['trash_type_id']] ?? 0, 2)}}kg</h3>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="report_user_type" role="tabpanel" aria-labelledby="report_day">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Người đổ rác nhiều nhất theo loại rác</h4>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th>Loại rác</th>
                                                    <th>Tên người đổi rác</th>
                                                    <th>Số lượng</th>
                                                </tr>
                                                @foreach($trash_type_list as $trash_type)
                                                    <tr>
                                                        <td><i class="menu-icon mdi mdi-label" style="color: {{$trash_type['trash_type_color']}}"></i>&nbsp;
                                                            {{$trash_type['trash_type_name']}}
                                                        </td>
                                                        <td>{{$max_type_user[$trash_type['trash_type_id']]["user_name"] ?? 'Chưa có ai'}}</td>
                                                        <td>{{number_format($max_type_user[$trash_type['trash_type_id']]["total"] ?? 0, 2)}}kg</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Người đổ rác nhiều nhất theo cụm</h4>

                                        <div class="dropdown">
                                            <button class="btn btn-primary text-white dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Chọn vị trí của cụm
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3" data-popper-placement="top-start">
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    @foreach($trash_location_list as $trash_location)
                                                        <a class="dropdown-item" data-bs-toggle="tab" href="#report_user_location_{{$trash_location['trash_location_id']}}" role="tab" aria-controls="report_user_location">
                                                            {{$trash_location["trash_location_name"]}}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-content tab-content-basic">
                                            @php $first = true; @endphp
                                            @foreach($trash_location_list as $trash_location)
                                                @php $trash_location_id = $trash_location['trash_location_id']; @endphp
                                                <div class="tab-pane fade show @if($first) active @endif" id="report_user_location_{{$trash_location_id}}" role="tabpanel" aria-labelledby="report_user_location_{{$trash_location_id}}">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tr>
                                                                <th>Tên cụm</th>
                                                                <th>Tên người đổi rác</th>
                                                                <th>Số lượng</th>
                                                            </tr>
                                                            @foreach($trash_group_list[$trash_location_id] ?? [] as $trash_group)
                                                                <tr>
                                                                    <td>
                                                                        {{$trash_group['trash_group_name']}}
                                                                    </td>
                                                                    <td>{{$max_group_user[$trash_group['trash_group_id']]["user_name"] ?? 'Chưa có ai'}}</td>
                                                                    <td>{{number_format($max_group_user[$trash_group['trash_group_id']]["total"] ?? 0, 2)}}kg</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                                @php $first = false; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script></script>
@endsection
