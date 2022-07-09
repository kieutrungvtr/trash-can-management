@extends('layouts.admin')

@section('page_title')
    {{__('Danh sách dữ liệu')}}
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
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="report_user_tab" data-bs-toggle="tab"
                               href="#report_user_type" role="tab" aria-controls="report_day" aria-selected="true">
                                Người đổ rác nhiều nhất
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="report_user_type" role="tabpanel"
                         aria-labelledby="report_day">
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
                                                        <td><i class="menu-icon mdi mdi-label"
                                                               style="color: {{$trash_type['trash_type_color']}}"></i>&nbsp;
                                                            {{$trash_type['trash_type_name']}}
                                                        </td>
                                                        <td>{{$max_type_user[$trash_type['trash_type_id']]["user_name"] ?? 'Chưa có ai'}}</td>
                                                        <td>{{number_format($max_type_user[$trash_type['trash_type_id']]["total"] ?? 0, 2)}}
                                                            kg
                                                        </td>
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
                                            <button class="btn btn-primary text-white dropdown-toggle" type="button"
                                                    id="dropdownMenuSizeButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                {{current($trash_location_list)['trash_location_name'] ?? 'Chọn vị trí của cụm'}}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton"
                                                 data-popper-placement="top-start">
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    @foreach($trash_location_list as $trash_location)
                                                        <a class="group-dropdown dropdown-item" data-bs-toggle="tab"
                                                           href="#report_user_location_{{$trash_location['trash_location_id']}}"
                                                           role="tab" aria-controls="report_user_location">
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
                                                <div class="tab-pane fade show @if($first) active @endif"
                                                     id="report_user_location_{{$trash_location_id}}" role="tabpanel"
                                                     aria-labelledby="report_user_location_{{$trash_location_id}}">
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
                                                                    <td>{{number_format($max_group_user[$trash_group['trash_group_id']]["total"] ?? 0, 2)}}
                                                                        kg
                                                                    </td>
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


                <div class="tab-pane fade show active" id="listing" role="tabpanel" aria-labelledby="report_day">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Danh sách dữ liệu</h4>

                                    <form action="{{Request::url()}}">
                                        <input type="hidden" name="group" value="{{$group_id}}">
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label for="from">Từ ngày</label>
                                                <input type="date" id="from" name="from" value="{{$from}}"
                                                       class="form-control"/>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="to">Đến ngày</label>
                                                <input type="date" id="to" name="to" value="{{$to}}"
                                                       class="form-control"/>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="type">Loại rác thải</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option></option>
                                                    @foreach($trash_type_list as $trash_type)
                                                        <option value="{{$trash_type["trash_type_id"]}}">
                                                            {{$trash_type["trash_type_name"]}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="location">Vị trí</label>
                                                <select class="form-control" id="location" name="location">
                                                    <option></option>
                                                    @foreach($trash_location_list as $trash_location)
                                                        <option value="{{$trash_location["trash_location_id"]}}">
                                                            {{$trash_location["trash_location_name"]}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="location">Vị trí</label>
                                                <select class="form-control" id="location" name="location">
                                                    <option></option>
                                                    @foreach($trash_group_list_map as $trash_group)
                                                        <option value="{{$trash_group["trash_group_id"]}}">
                                                            {{$trash_group["trash_group_name"]}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label style="visibility: hidden">SUBMIT</label><br/>
                                                <button type="submit"
                                                        class="form-control btn btn-primary me-2 text-white">Tìm kiếm
                                                </button>
                                            </div>
                                            <div class="col-lg-12">

                                                <button type="submit"
                                                        formaction="/admin/data/export"
                                                        formtarget="_blank"
                                                        class="btn btn-primary me-2 text-white">
                                                    <i class="icon-download"></i>XUẤT DỮ LIỆU
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                @foreach($heading as $label)
                                                    <th>{{$label}}</th>
                                                @endforeach
                                            </tr>
                                            @foreach($listing as $row)
                                                <tr>
                                                    @foreach($row as $column)
                                                        <td>{{$column}}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </table>
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
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-script')

    <script>
        $(function () {
            $("a.group-dropdown").on("click", function() {
                $('#dropdownMenuSizeButton').text($(this).text());
            });
        })
    </script>
@endsection
