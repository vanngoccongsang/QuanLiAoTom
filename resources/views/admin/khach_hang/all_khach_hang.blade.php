@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table" style=" overflow-x: scroll;">
            <div class="box-header">
                <h3>KHÁCH HÀNG</h3>
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
                    <form class="" action="{{ URL::to('/save-khach-hang') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <p class="box-title">THÊM KHÁCH HÀNG</p>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="form-group">
                                <label for="exampleInputPassword1">Loại khách hàng <span style="color: red">*</span></label>
                                <select class="form-control" name="loai_khach_hang" id="" style="">
                                    <option value="Tư nhân">Tư nhân</option>
                                    <option value="Chợ">Chợ</option>
                                    <option value="Nhà hàng">Nhà hàng</option>
                                    <option value="Công ty chế biến thực phẩm">Công ty chế biến thực phẩm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tên khách hàng <span style="color: red">*</span></label>
                                <input type="text" name="ten_khach_hang" class="form-control" value=""
                                    placeholder="Tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số điện thoại <span style="color: red">*</span></label>
                                <input type="number" name="so_dien_thoai" class="form-control" value=""
                                    placeholder="Số điện thoại">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Địa chỉ <span style="color: red">*</span></label>
                                <input type="text" name="dia_chi"class="form-control" value=""
                                    placeholder="Địa chỉ">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ghi chú </label>
                                <input type="text" name="ghi_chu"class="form-control" value=""
                                    placeholder="Ghi chú">
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Tạo khách hàng</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="box-body" style="margin-bottom: 40px">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="padding: 5px;">
                    <div class="row">
                        <div class="" style="margin-bottom: 40px;">
                            <table id="table-khach-hang" class="table table-bordered table-striped dataTable"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên khách hàng</th>
                                        <th>Loại khách hàng</th>
                                        <th>SDT</th>
                                        <th style="width: 300px;">Địa chỉ</th>
                                        <th>Ghi chú</th>
                                        <th style="width: 100px;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    var dataTable = $('#table-khach-hang').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        repornSive: true,
                                        ajax: {
                                            url: "{{ route('thiet-lap.khach_hang') }}",
                                            data: function(d) {
                                                d.kh_lay_loai_loc = $('select[name="kh_lay_loai_loc"]').val();
                                                d.kh_lay_ten_loc = $('select[name="kh_lay_ten_loc"]').val();
                                            }
                                        },
                                        columns: [{
                                                data: 'id_khach_hang',
                                                name: 'id_khach_hang'
                                            },
                                            {
                                                data: 'ten_khach_hang',
                                                name: 'ten_khach_hang'
                                            },
                                            {
                                                data: 'loai_khach_hang',
                                                name: 'loai_khach_hang'
                                            },
                                            {
                                                data: 'so_dien_thoai',
                                                name: 'so_dien_thoai'
                                            },
                                            {
                                                data: 'dia_chi',
                                                name: 'dia_chi'
                                            },
                                            {
                                                data: 'ghi_chu',
                                                name: 'ghi_chu'
                                            },
                                            {
                                                data: 'Action',
                                                name: 'Action'
                                            },
                                        ]
                                    });
                                    $('#form-sub-khach-hang').on('submit', function(e) {
                                        e.preventDefault();
                                        dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="box">
                <div class="box-header-1" style="color: #444;display: block; padding: 10px; position: relative;margin-bottom: -20px;">
                    <p class="box-title" style="font-size: 18px;">Danh sách khách hàng</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x: scroll;">
                    <div class="group-btn" style="margin-bottom: 10px;">
                        <form action="{{ URL::to('/loc-khach-hang') }}" method="get" id="form-sub-khach-hang"
                            style="justify-content: space-between;">
                            {{ csrf_field() }}
                            <div class="khu" style="display: flex; grid-gap: 5px;">
                                {{-- <p>Khu nuôi</p> --}}
                                <select name="kh_lay_loai_loc" value="" style="width: 150px; font-family: 'Source Sans Pro';">
                                    <option value="">Chọn loại KH</option>
                                    @foreach ($khach_hang as $val)
                                        <option value="{{ $val->loai_khach_hang }}">{{ $val->loai_khach_hang }}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" name="kh_lay_ten_loc" value="" style="width: 150px; font-family: 'Source Sans Pro';">
                                    <option value="">Chọn tên KH</option>
                                    @foreach ($khach_hang as $val)
                                        <option value="{{ $val->ten_khach_hang }}">{{ $val->ten_khach_hang }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    <button type="submit" class="btn btn-block btn-primary">Lọc</button>
                                </div>
                            </div>
                            @can('add.khach.hang')
                                <div style="margin-left: 15px;">
                                    <button id="myBtn" class="btn btn-block btn-info" style="width: 150px;">Tạo khách hàng</button>
                                </div>
                            @endcan
                        </form>
                    </div>
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"
                    style="width: 100%; font-family: Source Sans Pro; font-size: 14px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-khach-hang" style="width: 100%; font-size: 14px;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên khách hàng</th>
                                            <th>Loại khách hàng</th>
                                            <th>SĐT</th>
                                            <th style="width: 300px;">Địa chỉ</th>
                                            <th>Ghi chú</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên khách hàng</th>
                                            <th>Loại khách hàng</th>
                                            <th>SDT</th>
                                            <th style="width: 300px;">Địa chỉ</th>
                                            <th>Ghi chú</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-khach-hang').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornSive: true,
                                            ajax: {
                                                url: "{{ route('thiet-lap.khach_hang') }}",
                                                data: function(d) {
                                                    d.kh_lay_loai_loc = $('select[name="kh_lay_loai_loc"]').val();
                                                    d.kh_lay_ten_loc = $('select[name="kh_lay_ten_loc"]').val();
                                                }
                                            },
                                            columns: [{
                                                    data: 'id_khach_hang',
                                                    name: 'id_khach_hang'
                                                },
                                                {
                                                    data: 'ten_khach_hang',
                                                    name: 'ten_khach_hang'
                                                },
                                                {
                                                    data: 'loai_khach_hang',
                                                    name: 'loai_khach_hang'
                                                },
                                                {
                                                    data: 'so_dien_thoai',
                                                    name: 'so_dien_thoai'
                                                },
                                                {
                                                    data: 'dia_chi',
                                                    name: 'dia_chi'
                                                },
                                                {
                                                    data: 'ghi_chu',
                                                    name: 'ghi_chu'
                                                },
                                                {
                                                    data: 'Action',
                                                    name: 'Action'
                                                },
                                            ]
                                        });
                                        $('#form-sub-khach-hang').on('submit', function(e) {
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
@endsection
