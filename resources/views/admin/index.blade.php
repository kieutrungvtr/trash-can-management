@extends('layouts.admin')


@section('page_title')
    Trang chủ
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body d-flex justify-content-between bd-highlight mb-3" style="display: flex ">

                    <a href="/admin/trash/create_qr">
                        <button type="button" class="btn btn-info btn-lg btn-block"><strong>TẠO QR CODE</strong></button>
                    </a>
                    <a href="/admin/stats/trash_group">
                        <button type="button" class="btn btn-success btn-lg btn-block"><strong>{{__('Chart 1')}}</strong></button>
                    </a>
                    <a href="/admin/stats/trash_group_type">
                        <button type="button" class="btn btn-success btn-lg btn-block"><strong>{{__('Chart 2')}}</strong></button>
                    </a>
                    <a href="/admin/stats/line_week">
                        <button type="button" class="btn btn-success btn-lg btn-block"><strong>{{__('Chart 3')}}</strong></button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
