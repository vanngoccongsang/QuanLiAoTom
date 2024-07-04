@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table">
            <div class="box-header">
                <h2>NHẬP VẬT TƯ</h2>
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
                        <form class="" action="{{ URL::to('/save-khu-nuoi') }}" method="post">
                            {{ csrf_field() }}
                            <div class="box box-primary">
                            <div class="box-header with-border">
                                <p class="box-title">THÊM KHU NUÔI</p>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                                {{-- <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mã khu</label>
                                        <input type="text" name="ma_khu" class="form-control" value="" placeholder="Mã khu">
                                </div> --}}
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên khu</label>
                                    <input type="text" name="ten_khu" class="form-control" value="" placeholder="Tên khu">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Địa chỉ khu</label>
                                    <input type="text" name="dia_chi"class="form-control" value="" placeholder="Địa chỉ khu">
                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputPassword1">Trạng thái</label>
                                    <select class="form-control" name="trang_thai" id="" style="">
                                        <option value="Hoạt động">Hoạt động</option>
                                        <option value="Ngừng hoạt động">Ngừng hoạt động</option>
                                    </select>
                                </div> --}}
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Tạo khu</button>
                                </div>
                        </form>
                    </div>
                </div>
                {{-- <script>
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
                </script> --}}
            </div>
            <div class="box">
                <div class="box-header" >
                    <p class="box-title">Lịch sử nhập - <span style="color: rgb(227, 99, 60)">{{ $lay_ten_vat_tu->ten_vat_tu }}</span></p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x: scroll;">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"
                    style="font-size: 14px; width: 100%; font-family: Source Sans Pro;">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-lich-su-nhap-vat-tu" style="width: 100%; font-size: 14px;overflow-x: scroll;font-family: Source Sans Pro;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày nhập</th>
                                            <th>Số lượng nhập</th>
                                            <th>Giá tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày nhập</th>
                                            <th>Số lượng nhập</th>
                                            <th>Giá tiền</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-lich-su-nhap-vat-tu').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornSive: true,
                                            ajax: {
                                                url: "{{ route('lich_su_nhap_vat_tu',['ma_vat_tu' => ".$ma_vat_tu."]) }}",
                                                data: function(d) {
                                                    d.vat_tu_lay_ls_loc = $('select[name="vat_tu_lay_ls_loc"]').val();
                                                }
                                            },
                                            columns: [
                                                {
                                                    data: 'id_nhap_vat_tu',
                                                    name: 'id_nhap_vat_tu'
                                                },
                                                {
                                                    data: 'ngay_nhap',
                                                    name: 'ngay_nhap'
                                                },
                                                {
                                                    data: 'so_luong_nhap',
                                                    name: 'so_luong_nhap'
                                                },
                                                {
                                                    data: 'gia_tien',
                                                    name: 'gia_tien'
                                                },
                                            ]
                                        });
                                        $('#form-sub').on('submit', function(e) {
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
@endsection
