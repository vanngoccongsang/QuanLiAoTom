@extends('welcome1')
@section('content')
    <section class="khoi-tao" style="">
        <div class="box-data-table" >
            <div class="box-header">
                <h3>CHỈ SỐ MÔI TRƯỜNG</h3>
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
            </div>
            {{-- <div class="box-body" style="margin-bottom: 120px">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="">
                            <table id="table-moi-truong" class="table table-bordered table-striped dataTable" style="font-family: 'Source Sans Pro';
                            font-size: 16px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 170px;">Thông tin</th>
                                        <th>Ngày</th>
                                        <th>Độ kiềm</th>
                                        <th>Độ pH</th>
                                        <th>°C KK sáng</th>
                                        <th>°C KK chiều</th>
                                        <th>°C nước sáng</th>
                                        <th>°C nước chiều</th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    var dataTable = $('#table-moi-truong').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        repornsive: true,
                                        // ajax: "{{ route('thiet-lap.nhat_ky') }}",
                                        ajax:
                                        {
                                            url:  "{{ route('thiet-lap.moi_truong') }}",
                                            data: function ( d ) {
                                                d.mt_lay_ao_loc = $('select[name="mt_lay_ao_loc"]').val();
                                                d.mt_lay_khu_loc = $('select[name="mt_lay_khu_loc"]').val();
                                                d.mt_lay_vu_loc = $('select[name="mt_lay_vu_loc"]').val();
                                            }
                                        },
                                        columns: [
                                            {
                                                data: 'thong_tin',
                                                name: 'thong_tin'
                                            },
                                            {
                                                data: 'ngay',
                                                name: 'ngay'
                                            },
                                            {
                                                data: 'do_kiem',
                                                name: 'do_kiem'
                                            },
                                            {
                                                data: 'do_ph',
                                                name: 'do_ph'
                                            },
                                            {
                                                data: 'to_khong_khi_sang',
                                                name: 'to_khong_khi_sang'
                                            },
                                            {
                                                data: 'to_khong_khi_chieu',
                                                name: 'to_khong_khi_chieu'
                                            },
                                            {
                                                data: 'to_nuoc_sang',
                                                name: 'to_nuoc_sang'
                                            },
                                            {
                                                data: 'to_nuoc_chieu',
                                                name: 'to_nuoc_chieu'
                                            },

                                            {
                                                data: 'Action',
                                                name: 'Action'
                                            },
                                        ]
                                    });
                                    $('#form-sub-moi-truong').on('submit', function(e) {
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
                <div class="box-header" style="margin-bottom: -20px;">
                    <p class="box-title">Danh sách chỉ số môi trường</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x: scroll;">
                    <div class="group-btn" style="margin-bottom: 10px;">
                        <form action="{{ URL::to('/loc-moi-truong') }}" method="get" id="form-sub-moi-truong" style="">
                            {{ csrf_field() }}
                            <div class="ao" style="display: flex; grid-gap: 5px;">
                                {{-- <p>Khu nuôi</p> --}}
                                <div class="ao">
                                    {{-- <p>Khu nuôi</p> --}}
                                    <select name="lay_ao_loc" id="lay_ao_loc" value="" style="width: 100px;">
                                        <option value="">Chọn ao</option>
                                        @foreach ($ao_nuoi as $ao)
                                            <option value="{{ $ao->ma_ao }}">{{ $ao->ten_ao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="khu">
                                    {{-- <p>Khu nuôi</p> --}}
                                    <select name="lay_khu_loc" value="" style="width: 100px;">
                                        <option value="">Chọn khu</option>
                                        @foreach ($khu_nuoi as $khu)
                                            <option value="{{ $khu->ma_khu }}">{{ $khu->ten_khu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="vu">
                                    {{-- <p>Mùa vụ</p> --}}
                                    <select name="lay_vu_loc" value="" style="width: 100px;">
                                        <option value="">Chọn vụ</option>
                                        @foreach ($vu_nuoi as $vu)
                                            <option value="{{ $vu->ma_vu }}">{{ $vu->ten_vu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-block btn-primary">Lọc</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"
                    style="font-size: 14px; width: 100%; font-family: Source Sans Pro;">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-moi-truong" style="width: 100%; font-size: 14px;overflow-x: scroll;font-family: Source Sans Pro;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Thông tin</th>
                                            <th>Ngày</th>
                                            <th>Độ kiềm</th>
                                            <th>Độ pH</th>
                                            <th>°C KK sáng</th>
                                            <th>°C KK chiều</th>
                                            <th>°C nước sáng</th>
                                            <th>°C nước chiều</th>
                                            {{-- <th style="width: 100px;">Action </th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Thông tin</th>
                                            <th>Ngày</th>
                                            <th>Độ kiềm</th>
                                            <th>Độ pH</th>
                                            <th>°C KK sáng</th>
                                            <th>°C KK chiều</th>
                                            <th>°C nước sáng</th>
                                            <th>°C nước chiều</th>
                                            {{-- <th>Action </th> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-moi-truong').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornsive: true,
                                            // ajax: "{{ route('thiet-lap.nhat_ky') }}",
                                            ajax:
                                            {
                                                url:  "{{ route('thiet-lap.moi_truong') }}",
                                                data: function ( d ) {
                                                    d.lay_ao_loc = $('select[name="lay_ao_loc"]').val();
                                                    d.lay_khu_loc = $('select[name="lay_khu_loc"]').val();
                                                    d.lay_vu_loc = $('select[name="lay_vu_loc"]').val();
                                                }
                                            },
                                            columns: [
                                                {
                                                    data: 'thong_tin',
                                                    name: 'thong_tin'
                                                },
                                                {
                                                    data: 'ngay',
                                                    name: 'ngay'
                                                },
                                                {
                                                    data: 'do_kiem',
                                                    name: 'do_kiem'
                                                },
                                                {
                                                    data: 'do_ph',
                                                    name: 'do_ph'
                                                },
                                                {
                                                    data: 'to_khong_khi_sang',
                                                    name: 'to_khong_khi_sang'
                                                },
                                                {
                                                    data: 'to_khong_khi_chieu',
                                                    name: 'to_khong_khi_chieu'
                                                },
                                                {
                                                    data: 'to_nuoc_sang',
                                                    name: 'to_nuoc_sang'
                                                },
                                                {
                                                    data: 'to_nuoc_chieu',
                                                    name: 'to_nuoc_chieu'
                                                },
                                                // {
                                                //     data: 'Action',
                                                //     name: 'Action'
                                                // },
                                            ]
                                        });
                                        $('#form-sub-moi-truong').on('submit', function(e) {
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
        $('#form-sub-moi-truong').on('submit', function(e){
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
