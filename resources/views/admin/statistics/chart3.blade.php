@extends('layouts.admin')

@section('page_title')
    {{__('Chart 3')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__('Chart 3')}}</h4>
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
                            <div class="col-md-2">
                                <br/>
                                <button type="submit" class="btn btn-primary me-2 w-100">Tìm kiếm</button>
                            </div>
                            <div class="col-md-2">
                                <br/>
                                <button type="submit" class="btn btn-primary me-2 w-100" name="export" value="1">
                                    <i class="icon-download"></i>Xuất dữ liệu
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <canvas id="lineChart" style="display: block; width: 100%; height: 500px" class="chartjs-render-monitor"></canvas>
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
                    position: 'bottom'
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data['datasets'][tooltipItem['datasetIndex']]['label']+": "+data['datasets'][tooltipItem['datasetIndex']]['data'][tooltipItem['index']] + "kg";
                        }
                    },
                }
            };
            var data = {!! json_encode($chart_data) !!};
            if ($("#lineChart").length) {
                var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
                // This will get the first returned node in the jQuery collection.
                var lineChart = new Chart(lineChartCanvas, {
                    type: 'bar',
                    data: data,
                    options: options
                });
            }
        });
    </script>
@endsection
