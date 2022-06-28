@extends('layouts.admin')

@section('page_title')
    Tạo QR Code
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tạo QR Code</h4>
                    <form class="forms-sample" action="/admin/trash/create_qr" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="trash_name">Tên thùng rác</label>
                            <input type="text" class="form-control" id="trash_name" name="trash_name" placeholder="Tên thùng rác" required>
                        </div>
                        <div class="form-group">
                            <label for="trash_type_index">Loại rác thải<span id="trash_type_color"></span></label>
                            <select class="form-control" id="trash_type_index" name="trash_type_index">
                                @foreach($trashType as $trashTypeData)
                                    <option value="{{$trashTypeData["trash_type_id"]}}">
                                        {{$trashTypeData["trash_type_name"]}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="trash_location_index">Vị trí</label>
                            <select class="form-control" id="trash_location_index" name="trash_location_index" onchange="var self = this;loadGroup(self)">
                                @foreach($trashLocation as $trashLocationData)
                                    <option value="{{$trashLocationData["trash_location_id"]}}">
                                        {{$trashLocationData["trash_location_name"]}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="trash_group_index">Cụm</label>
                            <select class="form-control" id="trash_group_index" name="trash_group_index">
                                @foreach($trashGroup[current($trashLocation)["trash_location_id"]??0]??[] as $trashGroupData)
                                    <option value="{{$trashGroupData["trash_group_id"]}}">
                                        {{$trashGroupData["trash_group_name"]}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="trash_address">Địa chỉ</label>
                            <input type="text" class="form-control" id="trash_address" name="trash_address" placeholder="Địa chỉ" required>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">TẠO QR</button>
                    </form>
                </div>
            </div>
        </div>
        @if($qrCode)
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Tạo QR Code</h4>
                    <img id="QR" src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl={{$qrCode}}" width="50%" height="auto" alt="Q"/>
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
                "<img src='" + source + "' width='100%' /></body></html>";
        }
        function printQR() {
            var source = $("#QR").attr("src");
            Pagelink = "about:blank";
            var pwa = window.open(Pagelink, "_new");
            pwa.document.open();
            pwa.document.write(ImagetoPrint(source));
            pwa.document.close();
        }

        var trash_group = {!! json_encode($trashGroup) !!};
        function loadGroup(self) {
            var trash_location_id = $(self).val();
            var trash_group_data = trash_group[trash_location_id] || [];


            console.log(self)
            console.log(trash_group)

            $("#trash_group_index").html("");
            for(var id in trash_group_data) {
                if(!trash_group_data.hasOwnProperty(id)) continue;

                var item = trash_group_data[id];
                console.log(item)
                $("#trash_group_index").append('<option value="'+item.trash_group_id+'">'+item.trash_group_name+'</option>')
            }
        }
    </script>
@endsection
