@extends('welcome1')
@section('content')
    <section class="khoi-tao" style="overflow-x: scroll">
        <div class="box-data-table">
            <div class="box-header">
                <h3>CHI TIẾT AO NUÔI</h3>
            </div>
            @if (Session::has('message'))
                <script>
                    swal("Thông báo", "{{ Session::get('message') }}", 'success', {
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
                    swal("Thông báo", "{{ Session::get('error') }}", 'error', {
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
            <div class="box">
                <div class="box-header"
                    style="color: #444;display: block; padding: 10px; text-align: left;margin-bottom: -20px;">
                    <p class="box-title">Danh sách chi tiết ao nuôi</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x: scroll;">
                    <div class="group-btn" style="margin-bottom: 10px;display: flex; justify-content: space-between;">
                        <form action="{{ URL::to('/loc-chi-tiet') }}" method="get" id="form-sub-chi-tiet-ao"
                            style="">
                            {{ csrf_field() }}
                            <div class="ao" style="display: flex; grid-gap: 5px;">
                                {{-- <p>Khu nuôi</p> --}}
                                <div class="ao">
                                    {{-- <p>Khu nuôi</p> --}}
                                    <select name="lay_ao_loc" id="lay_ao_loc" value="" style="width: 100px;">
                                        <option value="">Chọn ao</option>
                                        @foreach ($lay_ao_nuoi as $ao)
                                            <option value="{{ $ao->ma_ao }}">{{ $ao->ten_ao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="khu">
                                    {{-- <p>Khu nuôi</p> --}}
                                    <select name="lay_khu_loc" id="lay_khu_loc" value="" style="width: 100px;">
                                        <option value="">Chọn khu</option>
                                        @foreach ($lay_khu_nuoi as $khu)
                                            <option value="{{ $khu->ma_khu }}">{{ $khu->ten_khu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="vu">
                                    {{-- <p>Mùa vụ</p> --}}
                                    <select name="lay_vu_loc" id="lay_vu_loc" value="" style="width: 100px;">
                                        <option value="">Chọn vụ</option>
                                        @foreach ($lay_vu_nuoi as $vu)
                                            <option value="{{ $vu->ma_vu }}">{{ $vu->ten_vu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Lọc</button>
                            </div>
                        </form>
                        <div style="margin-left: 5px;">
                            <a href="{{ route('all.ao') }}">
                                <button type="button" class="btn btn-block btn-primary">Tất cả ao</button>
                            </a>
                        </div>
                    </div>
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"
                        style="font-size: 14px;width: 100%; font-family: Source Sans Pro;">
                        <div class="row" style="">
                            <div class="col-sm-12">
                                <table id="table-chi-tiet-ao"
                                    style="width: 100%; font-size: 14px;overflow-x: scroll;font-family: Source Sans Pro;"
                                    class="table table-bordered table-striped dataTable" role="grid"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Thông tin ao</th>
                                            <th>Ngày</th>
                                            <th>Tuổi</th>
                                            <th>Lượng thức ăn</th>
                                            <th>Lượng tôm SP</th>
                                            <th>Size</th>
                                            <th>Lượng tôm giống</th>
                                            <th>ADG</th>
                                            <th>FCR</th>
                                            <th>Hao hụt</th>
                                            <th>Tình trạng</th>
                                            <th>SL nhận/chiết</th>
                                            {{-- <th style="width: 100px;">Action </th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Thông tin ao</th>
                                            <th>Ngày</th>
                                            <th>Tuổi</th>
                                            <th>Lượng thức ăn</th>
                                            <th>Lượng tôm SP</th>
                                            <th>Size</th>
                                            <th>Lượng tôm giống</th>
                                            <th>ADG</th>
                                            <th>FCR</th>
                                            <th>Hao hụt</th>
                                            <th>Tình trạng</th>
                                            <th>SL nhận/chiết</th>
                                            {{-- <th>Action </th> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-chi-tiet-ao').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornsive: true,
                                            ajax: {
                                                url: "{{ route('thiet-lap.loc_chi_tiet_ao') }}",
                                                data: function(d) {
                                                    d.lay_khu_loc = $('select[name="lay_khu_loc"]').val();
                                                    d.lay_vu_loc = $('select[name="lay_vu_loc"]').val();
                                                    d.lay_ao_loc = $('select[name="lay_ao_loc"]').val();
                                                }
                                            },
                                            columns: [{
                                                    data: 'TT',
                                                    name: 'TT'
                                                },
                                                {
                                                    data: 'ngay',
                                                    name: 'ngay'
                                                },
                                                {
                                                    data: 'tuoi_tom',
                                                    name: 'tuoi_tom'
                                                },
                                                {
                                                    data: 'luong_thuc_an',
                                                    name: 'luong_thuc_an'
                                                },
                                                {
                                                    data: 'luong_tom_sp',
                                                    name: 'luong_tom_sp'
                                                },
                                                {
                                                    data: 'size',
                                                    name: 'size'
                                                },
                                                {
                                                    data: 'luong_tom_giong',
                                                    name: 'luong_tom_giong'
                                                },
                                                {
                                                    data: 'ADG',
                                                    name: 'ADG'
                                                },
                                                {
                                                    data: 'FCR',
                                                    name: 'FCR'
                                                },
                                                {
                                                    data: 'hao_hut',
                                                    name: 'hao_hut'
                                                },
                                                {
                                                    data: 'tinh_trang',
                                                    name: 'tinh_trang'
                                                },
                                                {
                                                    data: 'sl_nhan_chiet',
                                                    name: 'sl_nhan_chiet'
                                                },
                                            ]
                                        });
                                        $('#form-sub-chi-tiet-ao').on('submit', function(e) {
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
        $('#form-sub-chi-tiet-ao').on('submit', function(e){
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
