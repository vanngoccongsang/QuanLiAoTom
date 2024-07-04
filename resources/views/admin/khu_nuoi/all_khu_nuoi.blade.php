@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table">
            <div class="box-header">
                <p style="font-size: 25px;margin: 0px;">KHU NUÔI</p>
            </div>
            @if (Session::has('message'))
                <script>
                    swal("Thông báo", "{{ Session::get('message') }}", 'success',{
                    button: true,
                    button: "OK",
                    timer: 3000,
                    dangerMode: true,
                    });
                </script>
                @php
                    Session::put('message', null);
                @endphp
            @elseif(Session::has('error'))
                <script>
                    swal("Thông báo", "{{ Session::get('error') }}", 'error',{
                    button: true,
                    button: "OK",
                    timer: 3000,
                    dangerMode: true,
                    });
                </script>
                @php
                    Session::put('error', null);
                @endphp
            @endif
            <!-- The Modal -->
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <p class="close-form" style="font-size: 30px;"
                        onclick="document.getElementById('myModal').style.display='none'">&times;</p>
                    <form class="" action="{{ URL::to('/save-khu-nuoi') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <p class="box-title">THÊM KHU NUÔI</p>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tên khu <span style="color: red">*</span></label>
                                <input type="text" name="ten_khu" class="form-control" value=""
                                    placeholder="Tên khu">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Địa chỉ khu <span style="color: red">*</span></label>
                                <input type="text" name="dia_chi"class="form-control" value=""
                                    placeholder="Địa chỉ khu">
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Tạo khu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div>
            <form class="" action="{{ URL::to('/save-vi-tri') }}" method="post" style="display: flex; grid-gap: 5px;justify-content: flex-end;">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Tên khu:</label>
                        <select name="ma_khu" id="" style="height: 34px;">
                            <option value="">-Khu-</option>
                            @foreach ($khu_nuoi as $khu)
                                <option value="{{ $khu->ma_khu }}">{{ $khu->ten_khu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form">
                        <label for="latitude">Vĩ độ:</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" style="width: 100px;" required>
                    </div>
                    <div class="form">
                        <label for="longitude">Kinh độ:</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" style="width: 100px;" required>
                    </div>
                    <div class="form">
                        <button type="submit" class="btn btn-primary" style="margin-top: 28px;">Thêm</button>
                    </div>
            </form>
        </div>
        <div id="sethPhatMap" style="width: 100%; height: 400px;"></div>
        <div class="box">
            <div class="box-header" style="margin-bottom: -10px;">
                <p class="box-title">Danh sách khu nuôi</p>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x: scroll;">
                <div class="group-btn" style="margin-bottom: 10px;">
                    <form action="{{ URL::to('/loc-khu') }}" method="get" id="form-sub-ao"
                        style="display: flex;justify-content: space-between;">
                        {{ csrf_field() }}
                        <div class="khu" style="display: flex; grid-gap: 15px;">
                            {{-- <p>Khu nuôi</p> --}}
                            <select name="khu_lay_khu_loc" value=""
                                style="width: 100px;font-family: 'Source Sans Pro';">
                                <option value="">Chọn khu</option>
                                @foreach ($khu_nuoi as $khu)
                                    <option value="{{ $khu->ten_khu }}">{{ $khu->ten_khu }}</option>
                                @endforeach
                            </select>
                            <div>
                                <button type="submit" class="btn btn-block btn-primary" style="width: 50px;">Lọc</button>
                            </div>
                        </div>
                        @can('add.khu')
                            <div style="margin-left: 10px;">
                                {{-- <button id="myBtn" style="width: auto;" class="btn-sub-loc">Tạo khu</button> --}}
                                <button id="myBtn" class="btn btn-block btn-info" style="width: 150px;">Tạo khu</button>
                            </div>
                        @endcan
                    </form>
                </div>
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"
                    style="font-size: 14px; width: 100%; font-family: Source Sans Pro;">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="table-khu"
                                style="width: 100%; font-size: 14px;overflow-x: scroll;font-family: Source Sans Pro;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên khu</th>
                                        <th>Địa chỉ</th>
                                        <th>Trạng thái</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên khu</th>
                                        <th>Địa chỉ</th>
                                        <th>Trạng thái</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    var dataTable = $('#table-khu').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        repornSive: true,
                                        ajax: {
                                            url: "{{ route('thiet-lap.khu') }}",
                                            data: function(d) {
                                                d.khu_lay_khu_loc = $('select[name="khu_lay_khu_loc"]').val();
                                            }
                                        },
                                        columns: [{
                                                data: 'ma_khu',
                                                name: 'ma_khu'
                                            },
                                            {
                                                data: 'ten_khu',
                                                name: 'ten_khu'
                                            },
                                            {
                                                data: 'dia_chi',
                                                name: 'dia_chi'
                                            },
                                            {
                                                data: 'trang_thai',
                                                name: 'trang_thai'
                                            },
                                            {
                                                data: 'Action',
                                                name: 'Action'
                                            },
                                        ]
                                    });
                                    $('#form-sub-ao').on('submit', function(e) {
                                        e.preventDefault();
                                        dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        </div>
    </section>
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script>
        var mapObj = null;
        var defaultCoord = [10.7743, 106.6669]; // coord mặc định, 9 giữa HCMC
        var zoomLevel = 13;
        var mapConfig = {
            attributionControl: false, // để ko hiện watermark nữa
            center: defaultCoord, // vị trí map mặc định hiện tại
            zoom: zoomLevel, // level zoom
        };
        window.onload = function() {
            // init map
            mapObj = L.map('sethPhatMap', {attributionControl: false}).setView(defaultCoord, zoomLevel);

            // add tile để map có thể hoạt động, xài free từ OSM
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mapObj);

            var locations = <?php echo json_encode($javascript_locations); ?>;
            locations.forEach(function(location) {
            var {latitude, longitude, name, dia_chi} = location; // Destructuring assignment
            var marker = L.marker([latitude, longitude]).addTo(mapObj);
            var popupContent = "<b>" + name + "</b><br>" + dia_chi; // Tạo nội dung của popup
            marker.bindPopup(popupContent); // Gắn popup
        });
            // Mở popup của tất cả các marker với setTimeout để tránh xung đột
            setTimeout(function() {
                mapObj.eachLayer(function(layer) {
                    if (layer instanceof L.Marker) {
                        layer.openPopup();
                    }
                });
            }, 500);
            mapObj.on('click', function(e) {
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
        };
    </script>
@endsection
