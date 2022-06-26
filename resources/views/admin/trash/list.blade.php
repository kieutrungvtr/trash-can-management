@extends('layouts.admin')

@section('page_title')
    Danh sách thùng rác
@endsection

@section('content')
    <style>
        table td, table th {
            font-size: 1.2rem !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Danh sách thùng rác</h4>
                    <form action="{{Request::url()}}">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="location">Vị trí</label>
                                <select class="form-control" id="location" name="location">
                                    <option value="0">Tất cả</option>
                                    @foreach($trash_location_list as $trash_location)
                                        <option value="{{$trash_location["trash_location_id"]}}"
                                                @if ($trash_location["trash_location_id"] == $location)
                                                    selected="selected"
                                                @endif
                                        >
                                            {{$trash_location["trash_location_name"]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="group">Cụm</label>
                                <select class="form-control" id="group" name="group">
                                    <option value="0">Tất cả</option>
                                    @foreach($trash_group_list as $trash_group)
                                        <option value="{{$trash_group["trash_group_id"]}}"
                                                @if ($trash_group["trash_group_id"] == $group)
                                                    selected="selected"
                                                @endif
                                        >
                                            {{$trash_group["trash_group_name"]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="type">Loại rác</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="0">Tất cả</option>
                                    @foreach($trash_type_list as $trash_type)
                                        <option value="{{$trash_type["trash_type_id"]}}"
                                                @if ($trash_type["trash_type_id"] == $type)
                                                    selected="selected"
                                                @endif
                                        >
                                            {{$trash_type["trash_type_name"]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <br/>
                                <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="font-size: 24px !important;">
                            <thead>
                            <tr>
                                <th>Tên thùng rác</th>
                                <th>Vị trí</th>
                                <th>Cụm</th>
                                <th>Loại rác</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($trash_list as $trash)
                            <tr>
                                <td class="py-1">{{$trash["trash_name"]}}</td>
                                <td>{{$trash_location_list[$trash["trash_location_index"]]['trash_location_name']??''}}</td>
                                <td>{{$trash_group_list[$trash["trash_group_index"]]['trash_group_name']??''}}</td>
                                <td>{{$trash_type_list[$trash["trash_type_index"]]['trash_type_name']??''}}</td>
                                <td>
                                    <a href="/admin/trash/detail?id={{$trash["trash_id"]}}" class="btn btn-info">
                                        QR COCE
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
