@extends('layouts.admin')

@section('page_title')
    {{__('Tổng quang')}}
@endsection
@section('custom-style')
    <style>
        .home-tab .nav-tabs .nav-item .nav-link.active {
            background-color: white;
        }

        th {
            white-space: normal !important;
            word-wrap: break-word;
            text-align: center;
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
                                                    <label for="from">Từ ngày</label>
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
                                                    <th>#</th>
                                                    @foreach($trash_type_list as $trash_type)
                                                        <th>{{$trash_type['trash_type_name']}}</th>
                                                    @endforeach
                                                </tr>
                                                @foreach($date_totals_list??[] as $date)
                                                    <tr>
                                                    <td><strong>{{$date}}</strong></td>
                                                        @foreach($trash_type_list as $trash_type)
                                                            <td>{{number_format($date_totals[$date][$trash_type['trash_type_id']]??0, 2)}}kg</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                        @if($max_page > 1)
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-end">
                                                    <li class="page-item"><a class="page-link" href="{{$page_uri}}&page=1"
                                                                             aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                                    </li>
                                                    @for($p = max($page-5, 1); $p <= min($page+5, $max_page); $p++)
                                                        <li class="page-item @if($p == $page) active @endif"><a
                                                                class="page-link"
                                                                href="{{$page_uri}}&page={{$p}}">{{$p}}</a></li>
                                                    @endfor
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{$page_uri}}&page={{($max_page??0)}}"
                                                           aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        @endif
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
                                        <div class="col flex-fill m-3 card p-4" style="max-width: 25rem; border: 4px {{App\Http\Controllers\Admin\StatisticsController::ConvertColorName($trash_type['trash_type_color'])}}7d solid">
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
                                        <div class="col flex-fill m-3 card p-4" style="max-width: 25rem; border: 4px {{App\Http\Controllers\Admin\StatisticsController::ConvertColorName($trash_type['trash_type_color'])}}7d solid">
                                            <p class="statistics-title">{{$trash_type['trash_type_name']}}</p>
                                            <h3 class="rate-percentage">{{number_format($avg_week_type_report[$trash_type['trash_type_id']] ?? 0, 2)}}kg</h3>
                                        </div>
                                    @endforeach
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
