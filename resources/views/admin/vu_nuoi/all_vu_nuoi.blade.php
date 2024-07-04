@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table" style="">
            <div class="box-header">
                <p style="font-size: 25px;margin: 0px;">VỤ NUÔI</p>
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
                    <form class="" action="{{ URL::to('/save-vu-nuoi') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box box-primary">
                        <div class="box-header with-border">
                            <p class="box-title">THÊM VỤ NUÔI</p>
                        </div>
                        <!-- /.box-header -->

                        <!-- form start -->
                            {{-- <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã vụ</label>
                                    <input type="text" name="ma_vu"class="form-control" placeholder="Mã vụ ">
                                </div> --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tên vụ <span style="color: red">*</span></label>
                                <input type="text" name="ten_vu" class="form-control" placeholder="Tên vụ">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ngày tạo <span style="color: red">*</span></label>
                                <input type="date" name="ngay_tao"class="form-date" placeholder="Số lượng ao nuôi">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ngày bắt đầu <span style="color: red">*</span></label>
                                <input type="date" name="ngay_bat_dau"class="form-date"  placeholder="Ngày bắt đầu">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ngày kết thúc <span style="color: red">*</span></label>
                                <input type="date" name="ngay_ket_thuc"class="form-date" placeholder="Số lượng khu nuôi">
                            </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" style="justify-content: right;display: flex;">
                                <button type="submit" class="btn btn-primary">Tạo vụ</button>
                            </div>
                    </form>
                </div>
            </div>
            </div>
            {{-- <div class="box-body" style="margin-bottom: 40px">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="padding: 5px;">
                    <div class="row" style="overflow-x: scroll;">
                        <div class="" style="margin-bottom: 40px;">
                            <table id="table-vu" class="table table-bordered table-striped dataTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên vụ</th>
                                        <th style="">Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    var dataTable = $('#table-vu').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        repornSive: true,
                                        // ajax: "{{ route('thiet-lap.vu') }}",
                                        ajax: {
                                            url: "{{ route('thiet-lap.vu') }}",
                                            data: function(d) {
                                                d.vu_lay_vu_loc = $('select[name="vu_lay_vu_loc"]').val();
                                            }
                                        },
                                        columns: [{
                                                data: 'ma_vu',
                                                name: 'ma_vu'
                                            },
                                            {
                                                data: 'ten_vu',
                                                name: 'ten_vu'
                                            },
                                            {
                                                data: 'ngay_bat_dau',
                                                name: 'ngay_bat_dau'
                                            },
                                            {
                                                data: 'ngay_ket_thuc',
                                                name: 'ngay_ket_thuc'
                                            },
                                            {
                                                data: 'ngay_tao',
                                                name: 'ngay_tao'
                                            },
                                            {
                                                data: 'trang_thai',
                                                name: 'trang_thai'
                                            },{
                                                data: 'Action',
                                                name: 'Action'
                                            }
                                        ]
                                    });
                                    $('#form-sub-vu').on('submit', function(e) {
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
                <div class="box-header" style="margin-bottom: -10px;">
                    <p class="box-title">Danh sách vụ nuôi</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x: scroll;">
                    <div class="group-btn" style="margin-bottom: 10px;">
                        <form action="{{ URL::to('/loc-vu') }}" method="get" id="form-sub-vu" style="display: flex; justify-content: space-between;">
                            {{ csrf_field() }}
                            <div class="vu" style="display: flex; grid-gap: 15px;">
                                {{-- <p>Khu nuôi</p> --}}
                                <select name="vu_lay_vu_loc" value="" style="width: 100px;">
                                    <option value="">Chọn vụ</option>
                                    @foreach ($vu_nuoi as $vu)
                                        <option value="{{ $vu->ten_vu }}">{{ $vu->ten_vu }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="date" >
                                <input type="date" > --}}
                                <button type="submit" class="btn btn-block btn-primary" style="width: 50px;">Lọc</button>
                            </div>
                            @can('add.vu')
                            <div style="margin-left: 10px;">
                                <button id="myBtn" class="btn btn-block btn-info" style="width: 150px;">Tạo vụ</button>
                            </div>
                            @endcan
                        </form>
                    </div>
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="font-size: 14px;width: 100%; font-family: Source Sans Pro;">
                        <div class="row" >
                            <div class="col-sm-12">
                                <table id="table-vu" style="width: 100%; font-size: 14px; font-family: Source Sans Pro;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên vụ</th>
                                            <th style="">Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Ngày tạo</th>
                                            <th>Trạng thái </th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên vụ</th>
                                            <th style="">Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Ngày tạo</th>
                                            <th>Trạng thái </th>
                                            <th>Action </th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-vu').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornSive: true,
                                            // ajax: "{{ route('thiet-lap.vu') }}",
                                            ajax: {
                                                url: "{{ route('thiet-lap.vu') }}",
                                                data: function(d) {
                                                    d.vu_lay_vu_loc = $('select[name="vu_lay_vu_loc"]').val();
                                                }
                                            },
                                            columns: [{
                                                    data: 'ma_vu',
                                                    name: 'ma_vu'
                                                },
                                                {
                                                    data: 'ten_vu',
                                                    name: 'ten_vu'
                                                },
                                                {
                                                    data: 'ngay_bat_dau',
                                                    name: 'ngay_bat_dau'
                                                },
                                                {
                                                    data: 'ngay_ket_thuc',
                                                    name: 'ngay_ket_thuc'
                                                },
                                                {
                                                    data: 'ngay_tao',
                                                    name: 'ngay_tao'
                                                },
                                                {
                                                    data: 'trang_thai',
                                                    name: 'trang_thai'
                                                },{
                                                    data: 'Action',
                                                    name: 'Action'
                                                }
                                            ]
                                        });
                                        $('#form-sub-vu').on('submit', function(e) {
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
