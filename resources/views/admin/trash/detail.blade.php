@extends('layouts.admin')

@section('page_title')
    Tạo QR Code
@endsection

@section('content')
    <style>
        table td, table th {
            font-size: 1rem !important;
        }
        td:last-child {
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>
    <div class="row">
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td style="background-color: {{$trash_type["trash_type_color"]}}; border-radius: 10px" colspan="2"></td>
                        </tr>
                        <tr>
                            <td style="width: 30%"><strong>Tên thùng rác</strong></td>
                            <td>{{$trash["trash_name"]}}</td>
                        </tr>
                        <tr>
                            <td><strong>Vị trí</strong></td>
                            <td>{{$trash_location["trash_location_name"]}}</td>
                        </tr>
                        <tr>
                            <td><strong>Cụm</strong></td>
                            <td>{{$trash_group["trash_group_name"]}}</td>
                        </tr>
                        <tr>
                            <td><strong>Loại rác</strong></td>
                            <td>{{$trash_type["trash_type_name"]}}</td>
                        </tr>
                        <tr>
                            <td><strong>Ghi chú</strong></td>
                            <td>{{$trash_type["trash_type_description"]}}</td>
                        </tr>
                        <tr>
                            <td><strong>Địa chỉ</strong></td>
                            <td>{{$trash["trash_address"]}}</td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        @if($qrCode)
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Tạo QR Code</h4>
                    <div id="print_qr">
                        <img width="50%" height="auto" id="QR" src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl={{$qrCode}}" alt="Q"/>
                        <div style="width: 50%; margin: auto;">
                            <strong>{{$trash_type["trash_type_name"]}}</strong>
                            <br/>
                            {{$trash_type["trash_type_description"]}}
                        </div>
                    </div>
                    <br/>
                    <button type="button" class="btn btn-primary me-2" onclick="printQR()">IN</button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        function ImagetoPrint(source) {
            return "<html><head><script>function step1(){\n" +
                "setTimeout('step2()', 10);}\n" +
                "function step2(){window.print();window.close()}\n" +
                "</scri" + "pt></head><body onload='step1()'>\n" +
                // "<img src='" + source + "' width='100%' />" +
                $('#print_qr').html().replace('<img width="50%"', '<img width="100%"')+
                "</body></html>";
        }
        function printQR() {
            var source = $("#QR").attr("src");
            Pagelink = "about:blank";
            var pwa = window.open(Pagelink, "_new");
            pwa.document.open();
            pwa.document.write(ImagetoPrint(source));
            pwa.document.close();
        }
    </script>
@endsection
