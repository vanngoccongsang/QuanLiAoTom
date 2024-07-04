@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table">
            <div class="box-header">
                <p style="font-size: 25px;margin: 0px;">AO NUÔI</p>
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
                    <form class="" action="{{ URL::to('/save-ao-nuoi') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box box-primary">
                        <div class="box-header with-border">
                            <p class="box-title">THÊM AO NUÔI</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInput">Tên ao <span style="color: red">*</span></label>
                                    <input type="text" name="ten_ao" class="form-control" placeholder="Tên ao">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput">Tên khu <span style="color: red">*</span></label>
                                    <select name="ma_khu" id="" style="">
                                        <option value="">--Chọn khu--</option>
                                        @foreach ($khu_nuoi_add as  $key => $khu)
                                            <option value="{{ $khu->ma_khu }}">{{ $khu->ten_khu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput">Tên vụ <span style="color: red">*</span></label>
                                    <select name="ma_vu" id="" style="">
                                        <option value="">--Chọn vụ--</option>
                                        @foreach ($vu_nuoi_add as  $key => $vu)
                                            <option value="{{ $vu->ma_vu }}">{{ $vu->ten_vu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput">Loại ao <span style="color: red">*</span></label>
                                    <input type="text" name="loai_ao"class="form-control" placeholder="Loại ao">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput">Diện tích <span style="color: red">*</span></label>
                                    <input type="number" name="dien_tich"class="form-control" placeholder="Diện tích (m²)">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput">Hình dạng ao <span style="color: red">*</span></label>
                                    <select name="hinh_dang" id="" style="">
                                        <option value="">--Chọn hình dạng--</option>
                                        <option value="Ao tròn">Ao tròn</option>
                                        <option value="Ao vuông">Ao vuông</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;" >
                                <button type="submit" class="btn btn-primary">Tạo ao</button>
                            </div>
                    </form>
                </div>
            </div>
            </div>
            {{-- <div class="box-body" style="margin-bottom: 40px">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="padding: 5px;">
                    <div class="row" >
                        <div class="" >
                            <table id="table-ao" class="table table-bordered table-striped dataTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên ao</th>
                                        <th>Tên khu</th>
                                        <th>Tên vụ</th>
                                        <th>Loại ao</th>
                                        <th>Diện tích</th>
                                        <th>Hình dạng</th>
                                        <th style="width: 100px;">Lợi nhuận</th>
                                        <th>Trạng thái </th>
                                        @role('quan ly ao|admin')
                                        <th>Báo cáo </th>
                                        <th style="width: 100px;">Action </th>
                                        @endrole
                                    </tr>
                                </thead>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    var dataTable = $('#table-ao').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        repornSive: true,
                                        ajax: {
                                    url: "{{ route('thiet-lap.ao') }}",
                                    data: function(d) {
                                        d.ao_lay_khu_loc = $('select[name="ao_lay_khu_loc"]').val();
                                        d.ao_lay_vu_loc = $('select[name="ao_lay_vu_loc"]').val();
                                        d.ao_lay_ao_loc = $('select[name="ao_lay_ao_loc"]').val();
                                        d.ao_lay_trang_thai = $('select[name="ao_lay_trang_thai"]').val();
                                    }
                                },
                                columns: [
                                    {
                                        data: 'ma_ao', type: 'string',
                                        name: 'ma_ao'
                                    },
                                    {
                                        data: 'ten_ao',
                                        name: 'ten_ao'
                                    },
                                    {
                                        data: 'ten_khu',
                                        name: 'ten_khu'
                                    },
                                    {
                                        data: 'ten_vu',
                                        name: 'ten_vu'
                                    },
                                    {
                                        data: 'loai_ao',
                                        name: 'loai_ao'
                                    },
                                    {
                                        data: 'dien_tich',
                                        name: 'dien_tich'
                                    },
                                    {
                                        data: 'hinh_dang',
                                        name: 'hinh_dang'
                                    },
                                    {
                                        data: 'loi_nhuan',
                                        name: 'loi_nhuan'
                                    },
                                    {
                                        data: 'trang_thai',
                                        name: 'trang_thai'
                                    },
                                    @role('quan ly ao|admin')
                                    {
                                        data: 'Action_xem',
                                        name: 'Action_xem'
                                    },

                                    {
                                        data: 'Action',
                                        name: 'Action'
                                    },
                                    @endrole
                                ]
                                });
                                    $('#form-sub-ao').on('submit', function(e) {
                                    e.preventDefault();
                                    dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                });
                                });
                            </script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var deleteButtons = document.querySelectorAll('.delete-btn');
                                    deleteButtons.forEach(function(button) {
                                        button.addEventListener('click', function(event) {
                                            event.preventDefault();
                                            var confirmDelete = confirm('Bạn có chắc chắn muốn xóa không?');
                                            if (confirmDelete) {
                                                var itemId = button.getAttribute('data-id');
                                                window.location.href = '/delete/' + itemId; // Điều hướng đến route xóa
                                            }
                                        });
                                    });
                                });
                                </script>

                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="box">
                <div class="box-header-1" style="color: #444;display: block; padding: 10px; position: relative;margin-bottom: -25px;">
                    <p class="box-title" style="font-size: 18px;">Danh sách ao nuôi</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style=" overflow: auto;">
                    <div class="group-btn" style="margin-bottom: 10px;">
                        <form action="{{ URL::to('/loc-ao') }}" method="get" id="form-sub-ao" style="justify-content: space-between;">
                            {{ csrf_field() }}
                            <div class="ao" style="display: flex; grid-gap: 5px;">
                                {{-- <p>Khu nuôi</p> --}}
                                <div class="ao">
                                    {{-- <p>Khu nuôi</p> --}}
                                    <select name="lay_ao_loc" id="lay_ao_loc" value="" style="width: 100px;font-family: 'Source Sans Pro';">
                                        <option value="">Chọn ao</option>
                                        @foreach ($ao_nuoi as $ao)
                                            <option value="{{ $ao->ma_ao }}">{{ $ao->ten_ao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="khu">
                                    {{-- <p>Khu nuôi</p> --}}
                                    <select name="lay_khu_loc" value="" style="width: 100px;font-family: 'Source Sans Pro';">
                                        <option value="">Chọn khu</option>
                                        @foreach ($khu_nuoi as $khu)
                                            <option value="{{ $khu->ma_khu }}">{{ $khu->ten_khu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="vu">
                                    {{-- <p>Mùa vụ</p> --}}
                                    <select name="lay_vu_loc" value="" style="width: 100px;font-family: 'Source Sans Pro';">
                                        <option value="">Chọn vụ</option>
                                        @foreach ($vu_nuoi as $vu)
                                            <option value="{{ $vu->ma_vu }}">{{ $vu->ten_vu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="trang-thai">
                                    {{-- <p>Mùa vụ</p> --}}
                                    <select name="lay_trang_thai" value="" style="width: 140px;font-family: 'Source Sans Pro';">
                                        <option value="">Chọn trạng thái</option>
                                        <option value="Hoạt động">Hoạt động</option>
                                        <option value="Đã bán">Đã bán</option>
                                        <option value="Ngừng hoạt động">Ngừng hoạt động</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-block btn-primary">Lọc</button>
                                </div>
                            </div>
                            @can('add.ao')
                            <div style="margin-left: 10px;">
                                <button id="myBtn" class="btn btn-block btn-info" style="width: 150px;">Tạo ao</button>
                            </div>
                            @endcan
                        </form>
                    </div>
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="font-size: 14px;width: 100%; font-family: Source Sans Pro;">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-ao" style="width: 100%; font-size: 14px; font-family: Source Sans Pro;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên ao</th>
                                            <th>Tên khu</th>
                                            <th>Tên vụ</th>
                                            <th>Loại ao</th>
                                            <th>Diện tích</th>
                                            <th>Hình dạng</th>
                                            <th>Lợi nhuận</th>
                                            <th>Trạng thái </th>
                                            @role('quan ly ao|admin')
                                            <th>Báo cáo </th>
                                            <th>Action </th>
                                            @endrole
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên ao</th>
                                            <th>Tên khu</th>
                                            <th>Tên vụ</th>
                                            <th>Loại ao</th>
                                            <th>Diện tích</th>
                                            <th>Hình dạng</th>
                                            <th>Lợi nhuận</th>
                                            <th>Trạng thái </th>
                                            @role('quan ly ao|admin')
                                            <th>Báo cáo </th>
                                            <th>Action </th>
                                            @endrole
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-ao').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornSive: true,
                                            ajax: {
                                        url: "{{ route('thiet-lap.ao') }}",
                                        data: function(d) {
                                            d.lay_khu_loc = $('select[name="lay_khu_loc"]').val();
                                            d.lay_vu_loc = $('select[name="lay_vu_loc"]').val();
                                            d.lay_ao_loc = $('select[name="lay_ao_loc"]').val();
                                            d.lay_trang_thai = $('select[name="lay_trang_thai"]').val();
                                        }
                                    },
                                    columns: [
                                        {
                                            data: 'ma_ao',
                                            name: 'ma_ao'
                                        },
                                        {
                                            data: 'ten_ao',
                                            name: 'ten_ao'
                                        },
                                        {
                                            data: 'ten_khu',
                                            name: 'ten_khu'
                                        },
                                        {
                                            data: 'ten_vu',
                                            name: 'ten_vu'
                                        },
                                        {
                                            data: 'loai_ao',
                                            name: 'loai_ao'
                                        },
                                        {
                                            data: 'dien_tich',
                                            name: 'dien_tich'
                                        },
                                        {
                                            data: 'hinh_dang',
                                            name: 'hinh_dang'
                                        },
                                        {
                                            data: 'loi_nhuan',
                                            name: 'loi_nhuan'
                                        },
                                        {
                                            data: 'trang_thai',
                                            name: 'trang_thai'
                                        },
                                        @role('quan ly ao|admin')
                                        {
                                            data: 'Action_xem',
                                            name: 'Action_xem'
                                        },

                                        {
                                            data: 'Action',
                                            name: 'Action'
                                        },
                                        @endrole
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
        function updateAoDropdown(data) {
            var aoDropdown = document.getElementById('lay_ao_loc');
            aoDropdown.innerHTML = '';
            var defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Chọn Ao';
            aoDropdown.appendChild(defaultOption);
            // Kiểm tra xem data có tồn tại và là một mảng không
            if (data && Array.isArray(data)) {
                // Nếu data là mảng, sử dụng forEach để lặp qua từng phần tử
                data.forEach(function(ao) {
                    var option = document.createElement('option');
                    option.value = ao.ma_ao;
                    option.textContent = ao.ten_ao;
                    aoDropdown.appendChild(option);
                });
            } else {
                console.error('Dữ liệu không hợp lệ');
            }
        }
        // function updateKhuDropdown(data) {
        //     var khuDropdown = document.getElementById('ao_lay_khu_loc');
        //     khuDropdown.innerHTML = '';
        //     var defaultOption = document.createElement('option');
        //     defaultOption.value = '';
        //     defaultOption.textContent = 'Chọn Khu';
        //     khuDropdown.appendChild(defaultOption);
        //     // Kiểm tra xem data có tồn tại và là một mảng không
        //     if (data && Array.isArray(data)) {
        //         // Nếu data là mảng, sử dụng forEach để lặp qua từng phần tử
        //         data.forEach(function(khu) {
        //             var option = document.createElement('option');
        //             option.value = khu.ma_khu;
        //             option.textContent = khu.ten_khu;
        //             khuDropdown.appendChild(option);
        //         });
        //     } else {
        //         console.error('Dữ liệu không hợp lệ');
        //     }
        // }
        // function updateVuDropdown(data) {
        //     var vuDropdown = document.getElementById('ao_lay_vu_loc');
        //     vuDropdown.innerHTML = '';
        //     var defaultOption = document.createElement('option');
        //     defaultOption.value = '';
        //     defaultOption.textContent = 'Chọn Vụ';
        //     vuDropdown.appendChild(defaultOption);
        //     // Kiểm tra xem data có tồn tại và là một mảng không
        //     if (data && Array.isArray(data)) {
        //         // Nếu data là mảng, sử dụng forEach để lặp qua từng phần tử
        //         data.forEach(function(vu) {
        //             var option = document.createElement('option');
        //             option.value = vu.ma_vu;
        //             option.textContent = vu.ten_vu;
        //             vuDropdown.appendChild(option);
        //         });
        //     } else {
        //         console.error('Dữ liệu không hợp lệ');
        //     }
        // }
        $('#form-sub-ao').on('submit', function(e){
            e.preventDefault();
            var formData = $(this).serialize(); // Chuyển đổi dữ liệu form thành chuỗi query
            // Gửi AJAX request để lấy dữ liệu mới từ máy chủ
            $.ajax({
                url: "{{ route('loc-bo-loc') }}",
                method: 'GET',
                data: formData,
                dataType: 'json',
                success: function(responseData) {
                    if(responseData){
                        var lay_ao_nuoi_moi = responseData.json_lay_ao_nuoi;
                        updateAoDropdown(lay_ao_nuoi_moi);
                        // var lay_khu_nuoi_moi = responseData.json_lay_khu_nuoi;
                        // updateKhuDropdown(lay_khu_nuoi_moi);
                        // var lay_vu_nuoi_moi = responseData.json_lay_vu_nuoi;
                        // updateVuDropdown(lay_vu_nuoi_moi);
                    }else{
                        console.error('Dữ liệu không hợp lệ.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>
@endsection
