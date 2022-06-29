@extends('layouts.admin')

@section('page_title')
    {{__('Chart 1')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__('Chart 1')}}</h4>
                    <div class="dropdown mb-4">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuSizeButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Chọn cụm
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton2" style="">
                            @foreach($trash_group_list as $trash_location_id => $trash_group_data)
                                <h6 class="dropdown-header">{{$trash_location_list[$trash_location_id]["trash_location_name"]}}</h6>
                                @foreach($trash_group_data as $trash_group)
                                    <a class="dropdown-item"
                                       href="{{URL::current()."?".http_build_query(array('group' => $trash_group["trash_group_id"], 'from'=>$from, 'to'=>$to))}}">{{$trash_group["trash_group_name"]}}</a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                            @endforeach
                        </div>


                        <form action="{{Request::url()}}">
                            <input type="hidden" name="group" value="{{$group_id}}">
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
                                    <br/>
                                    <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                    </div>
                    <canvas id="barChart" style="display: block; width: 100%; height: 500px" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        $(function() {
            var options = {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data['datasets'][0]['data'][tooltipItem['index']] + "kg";
                        }
                    },
                }
            };
            var data = {!! json_encode($chart_data) !!};
            if ($("#barChart").length) {
                var barChartCanvas = $("#barChart").get(0).getContext("2d");
                // This will get the first returned node in the jQuery collection.
                var barChart = new Chart(barChartCanvas, {
                    type: 'bar',
                    data: data,
                    options: options
                });
            }
        });
    </script>
@endsection
