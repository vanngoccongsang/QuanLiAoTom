@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table" >
            <div class="box-header">
                <p style="font-size: 25px;margin: 0px;">VẬT TƯ</p>
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
                    <p class="close-form" style="font-size: 30px;" onclick="document.getElementById('myModal').style.display='none'">&times;</p>
                    <form class="" action="{{ URL::to('/save-vat-tu') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box box-primary">
                        <div class="box-header with-border">
                            <p class="box-title">THÊM VẬT TƯ</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                            {{-- <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã vật tư</label>
                                    <input type="text" name="ma_vat_tu"class="form-control" placeholder="Mã vật tư">
                                </div> --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tên vật tư <span style="color: red">*</span></label>
                                <input type="text" name="ten_vat_tu" class="form-control" placeholder="Tên vật tư">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Loại <span style="color: red">*</span></label>
                                {{-- <input type="text" name="loai_vat_tu"class="form-control" placeholder="Loại vật tư"> --}}
                                <select class="form-control" name="loai_vat_tu" id="" style="height: 43px;">
                                    <option value="Thức ăn">Thức ăn</option>
                                    <option value="Tôm giống">Tôm giống</option>
                                    <option value="Thuốc khử khuẩn">Thuốc khử khuẩn</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả <span style="color: red">*</span></label>
                                <input type="text" name="mo_ta"class="form-control" placeholder="Mô tả">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nhà cung cấp <span style="color: red">*</span></label>
                                <input type="text" name="nha_cung_cap"class="form-control" placeholder="Nhà cung cấp">
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleInputPassword1">Số lượng nhập</label>
                                <input type="text" name="so_luong_nhap"class="form-control" placeholder="Số lượng nhập">
                            </div> --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Đơn vị <span style="color: red">*</span></label>
                                <select class="form-control" name="don_vi" id="" style="height: 43px;">
                                    <option value="Tạm dừng">Kg</option>
                                    <option value="Nguy hiểm">Bao</option>
                                    <option value="Đã xử lý">Gói</option>
                                    <option value="Đã xử lý">Con</option>
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleInputPassword1">Giá vật tư</label>
                                <input type="number" name="gia_vat_tu"class="form-control" placeholder="Giá vật tư">
                            </div> --}}
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                <button type="submit" class="btn btn-primary">Tạo vật tư</button>
                            </div>
                    </form>
                </div>
            </div>

            </div>
            <div class="box">
                <div class="box-header" style="margin-bottom: -10px;">
                    <p class="box-title">Danh sách vật tư</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x: scroll;">
                    <div class="group-btn" style="margin-bottom: 10px;">
                        <form action="{{ URL::to('/loc-vat-tu') }}" method="get" id="form-sub-vat-tu" style="display: flex; justify-content: space-between;">
                            {{ csrf_field() }}
                            <div class="vat-tu" style="display: flex; grid-gap: 10px;">
                                {{-- <p>Khu nuôi</p> --}}
                                <select name="vat_tu_lay_vt_loc" value="" style="width: 150px;font-family: 'Source Sans Pro';">
                                    <option value="">Chọn vật tư</option>
                                    @foreach ($vat_tu as $vt)
                                    <option value="{{ $vt->ma_vat_tu }}">{{ $vt->ten_vat_tu }}</option>
                                    @endforeach
                                </select>
                                <select name="vat_tu_lay_loai_loc" value="" style="width: 150px;font-family: 'Source Sans Pro';">
                                    <option value="">Chọn loại vật tư</option>
                                    @foreach ($loai_vat_tu as $vt)
                                    <option value="{{ $vt->loai_vat_tu }}">{{ $vt->loai_vat_tu }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-block btn-primary" style="width: 50px;">Lọc</button>
                            </div>
                            @can('add.vat.tu')
                                <div style="margin-left: 10px;">
                                    <button id="myBtn" class="btn btn-block btn-info" style="width: 150px;">Tạo vật tư</button>
                                </div>
                            @endcan
                        </form>
                    </div>
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"
                    style="font-size: 14px;width: 100%; font-family: Source Sans Pro;">
                        <div class="row" style="margin-bottom: 45px;">
                            <div class="col-sm-12">
                                <table id="table-vat-tu" style="width: 100%; font-size: 14px;overflow-x: scroll;font-family: Source Sans Pro;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên vật tư</th>
                                            <th>Loại</th>
                                            <th>Mô tả</th>
                                            <th>Nhà cung cấp</th>
                                            <th>Đơn vị</th>
                                            <th>Số lượng nhập</th>
                                            <th>Số lượng tồn</th>
                                            <th>Giá vật tư tồn</th>
                                            <th>Tổng tiền nhập</th>
                                            <th>Nhập</th>
                                            <th style="width: 100px;">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên vật tư</th>
                                            <th>Loại</th>
                                            <th>Mô tả</th>
                                            <th>Nhà cung cấp</th>
                                            <th>Đơn vị</th>
                                            <th>Số lượng nhập</th>
                                            <th>Số lượng tồn</th>
                                            <th>Giá vật tư tồn</th>
                                            <th>Giá</th>
                                            <th>Nhập</th>
                                            <th>Action </th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-vat-tu').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornSive: true,
                                            // ajax: "{{ route('thiet-lap.vat_tu') }}",
                                            ajax: {
                                            url: "{{ route('thiet-lap.vat_tu') }}",
                                            data: function(d) {
                                                d.vat_tu_lay_vt_loc = $('select[name="vat_tu_lay_vt_loc"]').val();
                                                d.vat_tu_lay_loai_loc = $('select[name="vat_tu_lay_loai_loc"]').val();
                                            }
                                        },
                                            columns: [{
                                                    data: 'ma_vat_tu',
                                                    name: 'ma_vat_tu'
                                                },
                                                {
                                                    data: 'ten_vat_tu',
                                                    name: 'ten_vat_tu'
                                                },
                                                {
                                                    data: 'loai_vat_tu',
                                                    name: 'loai_vat_tu'
                                                },
                                                {
                                                    data: 'mo_ta',
                                                    name: 'mo_ta'
                                                },
                                                {
                                                    data: 'nha_cung_cap',
                                                    name: 'nha_cung_cap'
                                                },
                                                {
                                                    data: 'don_vi',
                                                    name: 'don_vi'
                                                },
                                                {
                                                    data: 'so_luong_nhap',
                                                    name: 'so_luong_nhap'
                                                },
                                                {
                                                    data: 'so_luong_ton',
                                                    name: 'so_luong_ton'
                                                },
                                                {
                                                    data: 'gia_vat_tu_ton',
                                                    name: 'gia_vat_tu_ton'
                                                },
                                                {
                                                    data: 'gia_vat_tu',
                                                    name: 'gia_vat_tu'
                                                },
                                                {
                                                    data: 'lich_su_nhap',
                                                    name: 'lich_su_nhap'
                                                },
                                                {
                                                    data: 'Action',
                                                    name: 'Action'
                                                },
                                            ]
                                        });
                                        $('#form-sub-vat-tu').on('submit', function(e) {
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
@endsection
