@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table">
            <div class="box-header">
                <p style="font-size: 25px;">CHI TIẾT AO NUÔI</p>
                @foreach ($save_nk as $val)
                    <p style="font-size: 23px; color: rgb(255 63 63); position: static;">
                        {{ $val->ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }}
                        @if($sl_tom_end != null)
                            <p style="position: static;">(Sl tôm hiện tại: {{number_format($sl_tom_end)}} con)</p>
                        @else
                            <p style="position: static;">(Sl tôm hiện tại: Chưa cập nhật)</p>
                        @endif
                    </p>
                @endforeach
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Biểu đồ thống kê ngày nuôi</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body" style="">
                    <div class="chart">
                        <div id="bar-chart" height="200" width="auto"></div>
                        <div class="title-chart" style="grid-gap: 5px;position: sticky;">
                            <p class="col-sm-4"><i class="fa fa-fw fa-circle" style="color: #00a65a"></i>Lượng tôm giống</p>
                            <p class="col-sm-4"><i class="fa fa-fw fa-circle" style="color: #f56954"></i>Lượng thức ăn</p>
                            <p class="col-sm-4"><i class="fa fa-fw fa-circle" style="color: #87da4e"></i>Số tiền đã chi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="callout callout-danger" style="display: flex; grid-gap: 10px;">
            <i class="fa fa-money" aria-hidden="true" style="font-size: 30px;"></i>
            <h4>Tổng tiền đã chi khi nuôi: {{ number_format($tong_tien_chi_ao) }} VND</h4>
        </div>

        @if ($lay_trang_thai != 'Đã bán' && $lay_trang_thai != 'Ngừng hoạt động')
        {{-- <div class="group-btn-bao-cao-ao" style="overflow-x: scroll;display: flex;margin-bottom: 10px;grid-gap: 10px;">
            <div class="row">
                <div class="col-sm-3">
                    <button type="button" id="myBtn" class="btn btn-block btn-primary"
                    style="background-color: #98d5b6; width: 150px;">Bán tôm</button>
                </div>
                <div class="col-sm-3">
                    <button type="button" id="myBtn_chiet_tom" class="btn btn-block btn-primary"
                    style="background-color: #7cc9a2; width: 150px;">Sang/Chiết tôm</button>
                </div>
                <div class="col-sm-3">
                    <button type="button" id="myBtn_adg_fcr" class="btn btn-block btn-primary"
                    style="background-color: #35be77; width: 150px;">ADG/FCR/Hao hụt</button>
                </div>
                <div class="col-sm-3">
                    @can('add.chi.tiet.ao')
                        <button type="button" id="myBtn_add_ngay_nuoi" class="btn btn-block btn-primary"
                        style="background-color: #566ad7; width: 150px;">Thêm ngày nuôi</button>
                    @endcan
                </div>
            </div>
        </div> --}}
        <div class="group-btn-bao-cao-ao" style="margin-bottom: 10px;text-align: center;">
            <div class="d-flex justify-content-center flex-wrap" style="justify-content: center;">
                <button type="button" id="myBtn" class="btn btn-primary mb-2"
                style="background-color: #98d5b6">Bán tôm</button>
                <button type="button" id="myBtn_chiet_tom" class="btn btn-primary mb-2"
                style="background-color: #7cc9a2">Sang/Chiết tôm</button>
                <button type="button" id="myBtn_adg_fcr" class="btn btn-primary mb-2"
                style="background-color: #35be77">ADG/FCR/Hao hụt</button>
                @can('add.chi.tiet.ao')
                    <button type="button" id="myBtn_add_ngay_nuoi" class="btn btn-primary mb-2"
                    style="background-color: #566ad7">Thêm ngày nuôi</button>
                @endcan
            </div>
        </div>
        @endif

        <div class="box">
            <div class="box-header">
                @foreach ($save_nk as $val)
                <h4 class="box-title">Chi tiết ao nuôi ( {{ $val->ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }} )</h4>
                @endforeach
            </div>
            <!-- /.box-header -->
            <div class="box-body" style=" overflow: auto;">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"
                style="font-size: 14px; width: 100%; font-family: Source Sans Pro;">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="table-tong-ao" style="width: 100%; font-family: Source Sans Pro; font-size: 14px;"
                            class="table table-bordered table-striped dataTable" role="grid"
                            aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th>Ngày</th>
                                        <th>Tuổi</th>
                                        <th>Lượng thức ăn</th>
                                        <th>Lượng tôm SP</th>
                                        <th>Size</th>
                                        <th>Lượng tôm giống</th>
                                        <th>ADG</th>
                                        <th>FCR</th>
                                        <th>Hao hụt</th>
                                        <th>Sang/ Chiết</th>
                                        <th>SL nhận/chiết</th>
                                        <th>Tiền chi</th>
                                        <th></th>
                                        @if ($lay_trang_thai != 'Đã bán' && $lay_trang_thai != 'Ngừng hoạt động')
                                        <th >Action </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Tuổi</th>
                                        <th>Lượng thức ăn</th>
                                        <th>Lượng tôm SP</th>
                                        <th>Size</th>
                                        <th>Lượng tôm giống</th>
                                        <th>ADG</th>
                                        <th>FCR</th>
                                        <th>Hao hụt</th>
                                        <th>Sang/ Chiết</th>
                                        <th>SL nhận/chiết</th>
                                        <th>Tiền chi</th>
                                        <th></th>
                                        @if ($lay_trang_thai != 'Đã bán' && $lay_trang_thai != 'Ngừng hoạt động')
                                        <th >Action </th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    var dataTable = $('#table-tong-ao').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        repornSive: true,
                                        ajax: {
                                            url: "{{ route('all.bao_cao_ao', ['ma_ao' => ".$ma_ao.", 'ma_khu' => ".$ma_khu.", 'ma_vu' => ".$ma_vu."]) }}"
                                        },
                                        columns: [{
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
                                            {
                                                data: 'tong_tien',
                                                name: 'tong_tien'
                                            },
                                            {
                                                data: 'xem',
                                                name: 'xem'
                                            },
                                            @if ($lay_trang_thai != 'Đã bán' && $lay_trang_thai != 'Ngừng hoạt động')
                                            {
                                                data: 'Action',
                                                name: 'Action'
                                            },
                                            @endif
                                        ]
                                    });
                                    $('#form-sub-bao-cao-ao').on('submit', function(e) {
                                    e.preventDefault();
                                    dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="width: 75%;">
                <p class="close-form"
                    style="font-size: 30px;"onclick="document.getElementById('myModal').style.display='none'">&times;</p>
                <div class="box box-primary">
                    <form class="" action="{{ URL::to('/save-ban-tom/' . $ma_ao . '/' . $ten_khu . '/' . $ten_vu . '') }}"
                        method="post">
                        {{ csrf_field() }}
                        <div class="box-header with-border" style="text-align: center;">
                            <p class="box-title">BÁN TÔM</p>
                            @foreach ($save_nk as $val)
                            <p style="font-size: 16px; color: rgb(255 63 63); position: static;">
                                {{ $val->ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }}
                            </p>
                            @endforeach
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <h4 style="text-align: center;">Số lượng tôm trong ao hiện tại:
                                    {{ number_format($sl_tom_end) }} con</h4>
                            </div>
                            <div class="form-group">
                                <label>Chọn khách hàng mua tôm: <span style="color: red">*</span></label>
                                <select name="id_khach_hang" id="">
                                    <option value="">--Chọn khách hàng--</option>
                                    @foreach ($lay_khach_hang as $value)
                                        <option value="{{ $value->id_khach_hang }}">{{ $value->ten_khach_hang }}
                                            ({{ $value->loai_khach_hang }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Số kg tôm bán <span style="color: red">*</span></label>
                                <input type="number" name="so_kg_tom" id="so_kg_tom" class="form-control"
                                    placeholder="Số kg tôm bán">
                            </div>
                            <div class="form-group">
                                <label>Giá 1kg tôm hiện tại (VND) <span style="color: red">*</span></label>
                                <input type="number" name="gia_tom" id="gia_tom" class="form-control"
                                    placeholder="Giá 1kg tôm hiện tại" data-sl-tom-end="{{ $sl_tom_end }}">
                            </div>
                            <div class="form-group">
                                <label>Thành tiền: </label>
                                <p style="color: crimson;" id="thanh_tien"></p>
                                <input type="hidden" id="lay_thanh_tien" name="lay_thanh_tien" value="">
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Bán tôm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="myModal_chiet_tom" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="width: 80%;">
                <p class="close-form"
                    style="font-size: 30px;"onclick="document.getElementById('myModal_chiet_tom').style.display='none'">
                    &times;</p>
                <div class="box box-primary">
                    <form class="" action="{{ URL::to('/save-chiet-tom/' . $ma_ao . '') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-header with-border" style="text-align: center;">
                            <p class="box-title">CHIẾT TÔM</p>
                            @foreach ($save_nk as $val)
                            <p style="font-size: 16px; color: rgb(255 63 63); position: static;">
                                {{ $val->ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }}
                            </p>
                            @endforeach
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <h4 style="text-align: center;">Số lượng tôm trong ao hiện tại:
                                    {{ number_format($sl_tom_end) }} con</h4>
                            </div>
                            <div class="form-group">
                                <label>Số lượng tôm cần chiết (con) <span style="color: red">*</span></label>
                                <input type="number" name="so_luong_tom" class="form-control"
                                    placeholder="Số lượng tôm cần chiết">
                            </div>
                            <div class="form-group">
                                <label>Chọn ao nhận tôm chiết <span style="color: red">*</span></label>
                                <select name="ma_ao_nhan" id="">
                                    <option value="">--Chọn ao cùng vụ--</option>
                                    @foreach ($lay_ao_nuoi as $value)
                                        <option value="{{ $value->ma_ao }}">{{ $value->ten_ao }} - {{ $value->ten_khu }}
                                            - {{ $value->ten_vu }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Chiết tôm</button>
                        </div>
                    </form>
                </div>
                <div class="box box-primary">
                    <form class="" action="{{ URL::to('/save-sang-tom/' . $ma_ao . '') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-header with-border" style="text-align: center;">
                            <p class="box-title">SANG TÔM</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chọn ao nhận tôm sang <span style="color: red">*</span></label>
                                <select name="ma_ao_nhan_sang" id="">
                                    <option value="">--Chọn ao cùng vụ--</option>
                                    @foreach ($lay_ao_nuoi as $value)
                                        <option value="{{ $value->ma_ao }}">{{ $value->ten_ao }} - {{ $value->ten_khu }}
                                            - {{ $value->ten_vu }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Sang tôm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="myModal_can_mau" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <p class="close-form"
                    style="font-size: 30px;"onclick="document.getElementById('myModal_can_mau').style.display='none'">
                    &times;</p>
                <div class="box box-primary">
                    <form class="" action="{{ URL::to('/save-chiet-tom') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-header with-border" style="text-align: center;">
                            <p class="box-title">Cân mẫu</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <label>Số lượng tôm trong ao hiện tại: {{ number_format($sl_tom_end) }} con</label>
                            </div>
                            <div class="form-group">
                                <label>Số lượng tôm cân mẫu (con)</label>
                                <input type="number" name="gia_tom" id="so_luong_tom_mau" class="form-control"
                                    placeholder="Số lượng tôm của 1kg">
                            </div>
                            <div class="form-group">
                                <label>Số lượng kg cân mẫu (kg)</label>
                                <input type="number" name="gia_tom" id="so_kg_tom_mau" class="form-control"
                                    placeholder="Số lượng tôm của 1kg">
                            </div>
                            <div class="form-group">
                                <label>Size: </label>
                                <p style="color: crimson;" id="size_end"></p>
                                <input type="hidden" id="lay_size_end" name="lay_size_end" value="">
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cân</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="myModal_adg_fcr" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="width: 75%;">
                <p class="close-form"
                    style="font-size: 30px;"onclick="document.getElementById('myModal_adg_fcr').style.display='none'">
                    &times;</p>
                <div class="box box-primary">
                    <form class="" action="{{ URL::to('/tinh-adg/' . $ma_ao . '/' . $ma_khu . '/' . $ma_vu . '') }}"
                        method="post">
                        {{ csrf_field() }}
                        <div class="box-header with-border" style="text-align: center;">
                            <p class="box-title">ADG / FCR / Hao hụt</p>
                            @foreach ($save_nk as $val)
                            <p style="font-size: 16px; color: rgb(255 63 63); position: static;">
                                {{ $val->ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }}
                            </p>
                            @endforeach
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <h4 style="text-align: center;">Số lượng tôm trong ao hiện tại:
                                    {{ number_format($sl_tom_end) }} con</h4>
                            </div>
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-info"></i>Chú ý !</h4>
                                <p><span style="color: red">*</span> Kiểm tra size tôm, số lượng tôm trước khi tính (Khoảng cách tính tối thiểu 5 ngày).</p>
                                <p><span style="color: red">*</span> Lần đầu tính: Ngày đầu tiên và ngày mới nhất.</p>
                                <p><span style="color: red">*</span> Lần tiếp theo: Ngày đã tính gần nhất và ngày mới nhất.</p>


                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Tính ADG/ FCR/ Hao hụt</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="myModal_add_ngay_nuoi" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="width: 75%;">
                <p class="close-form"
                    style="font-size: 30px;"onclick="document.getElementById('myModal_add_ngay_nuoi').style.display='none'">
                    &times;</p>
                <div class="box box-primary">
                    @foreach ($save_nk as $key => $save_value)
                        <form class="" action="{{ URL::to('/save-chi-tiet-ao/' . $save_value->ma_ao) }}"
                            method="post">
                            {{ csrf_field() }}
                            <div class="box-header with-border" style="text-align: center;">
                                <p class="box-title">THÊM NGÀY NUÔI</p>
                                @foreach ($save_nk as $val)
                                <p style="font-size: 16px; color: rgb(255 63 63); position: static;">
                                    {{ $val->ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }}
                                </p>
                                @endforeach
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <input type="hidden" name="lay_ma_ao" value="{{ $save_value->ma_ao }}">
                                <input type="hidden" name="lay_ma_khu" value="{{ $save_value->ma_khu }}">
                                <input type="hidden" name="lay_ma_vu" value="{{ $save_value->ma_vu }}">
                                <!-- /.box-header -->
                                <!-- form start -->
                                <form role="form">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ngày nuôi <span style="color: red">*</span></label>
                                            <input type="date" name="ngay" value="{{ $input_ngay}}" class="form-control" placeholder="Ngày">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tuổi tôm <span style="color: red">*</span></label>
                                            <input type="number" name="tuoi_tom" value="{{ $input_tuoi }}" class="form-control"
                                                placeholder="Tuổi tôm">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Lượng tôm si phong <span style="color: red">*</span></label>
                                            <input type="number" name="luong_tom_sp"class="form-control"
                                                placeholder="Lượng tôm si phong">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Size tôm (SL tôm/ 1 kg)</label>
                                            <input type="number" name="size"class="form-control"
                                                placeholder="Size tôm (số con tôm/ 1 kg) (Null)">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Lượng tôm giống ({{number_format($sl_tom_end)}} con)</label>
                                            <input type="number" name="luong_tom_giong"class="form-control"
                                                placeholder="SL gần nhất: {{number_format($sl_tom_end)}} con">
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                        <button type="submit" class="btn btn-primary">Thêm ngày nuôi</button>
                                    </div>
                                </form>
                    @endforeach
                </div>
            </div>
        </div>
        <script>
            var y = <?php echo $bar_ngay; ?>;
            var a = <?php echo $bar_tom_giong; ?>;
            var b = <?php echo $bar_thuc_an; ?>;
            var c = <?php echo $bar_tien_chi; ?>;
            $(function() {
                var data = [];
                for (var i = 0; i < y.length; i++) {
                    data.push({
                        y: y[i],
                        a: a[i],
                        b: b[i],
                        c: c[i]
                    });
                }
                //BAR CHART
                var bar = new Morris.Bar({
                    element: 'bar-chart',
                    resize: true,
                    data: data,
                    barColors: ['#00a65a', '#f56954', '#87da4e'],
                    xkey: 'y',
                    ykeys: ['a', 'b', 'c'],
                    labels: ['Lượng tôm giống (con)', 'Lượng thức ăn (kg)', 'Tiền chi (VND)'],
                    hideHover: 'auto'
                });
            });
        </script>
        <script>
            // Get the input element for shrimp price
            var giaTomInput = document.getElementById("gia_tom");
            // Get the value of $sl_tom_end from the data attribute
            var slTomEnd = parseFloat(giaTomInput.getAttribute("data-sl-tom-end"));
            // Add event listener to detect changes in the input value
            giaTomInput.addEventListener("input", function() {
                // Get the current shrimp price entered by the user
                var giaTom = parseFloat(giaTomInput.value);
                // Check if the entered value is a valid number
                if (!isNaN(giaTom)) {
                    // Calculate the total price
                    var thanhTien = slTomEnd * giaTom;
                    // Format the total price with commas for thousands separators
                    var formattedThanhTien = thanhTien.toLocaleString(); // Using toLocaleString() for formatting
                    // Display the total price
                    document.getElementById("thanh_tien").textContent = formattedThanhTien +
                    " VND"; // Assuming Vietnamese Dong
                    document.getElementById("lay_thanh_tien").textContent =
                    formattedThanhTien; // Assuming Vietnamese Dong
                } else {
                    // If the entered value is not a valid number, display a message or clear the total price
                    document.getElementById("thanh_tien").textContent = "Vui lòng nhập giá hợp lệ.";
                }
            });
        </script>
        // {{-- Tinh tien --}}
        <script>
            // Function to calculate total price
            function calculateTotalPrice() {
                var soKgTom = parseFloat(document.getElementById("so_kg_tom").value);
                var giaTom = parseFloat(document.getElementById("gia_tom").value);

                var soLuongTomMau = parseFloat(document.getElementById("so_luong_tom_mau").value);
                var soKgTomMau = parseFloat(document.getElementById("so_kg_tom_mau").value);
                // var slTomEnd = parseFloat(document.getElementById("gia_tom").getAttribute("data-sl-tom-end"));

                if (!isNaN(soKgTom) && !isNaN(giaTom)) {
                    var thanhTien = soKgTom * giaTom;
                    document.getElementById("thanh_tien").textContent = thanhTien.toLocaleString() + " VND";
                    document.getElementById("lay_thanh_tien").value = thanhTien;
                } else {
                    document.getElementById("thanh_tien").textContent = "Vui lòng nhập số lượng và giá hợp lệ.";
                    document.getElementById("lay_thanh_tien").value = "";
                }

                if (!isNaN(soLuongTomMau) && !isNaN(soKgTomMau)) {
                    var sizeTom = soLuongTomMau / soKgTomMau;
                    document.getElementById("size_end").textContent = sizeTom.toLocaleString();
                    document.getElementById("lay_size_end").value = sizeTom;
                } else {
                    document.getElementById("size_end").textContent = "Vui lòng nhập số lượng và số cân nặng hợp lệ.";
                    document.getElementById("lay_size_end").value = "";
                }
            }
            // Event listener to detect changes in input values
            document.getElementById("so_kg_tom").addEventListener("input", calculateTotalPrice);
            document.getElementById("gia_tom").addEventListener("input", calculateTotalPrice);

            document.getElementById("so_luong_tom_mau").addEventListener("input", calculateTotalPrice);
            document.getElementById("so_kg_tom_mau").addEventListener("input", calculateTotalPrice);
        </script>
        {{-- Click btn ban tom --}}
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
        {{-- Click btn chiet tom --}}
        <script>
            // Get the modal
            var modal_chiet_tom = document.getElementById("myModal_chiet_tom");
            // Get the button that opens the modal
            var btn = document.getElementById("myBtn_chiet_tom");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal_chiet_tom.style.display = "block";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal_chiet_tom) {
                    modal_chiet_tom.style.display = "none";
                }
            }
        </script>
        {{-- Click btn adg... --}}
        <script>
            // Get the modal
            var modal_adg_fcr = document.getElementById("myModal_adg_fcr");
            // Get the button that opens the modal
            var btn = document.getElementById("myBtn_adg_fcr");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal_adg_fcr.style.display = "block";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal_adg_fcr) {
                    modal_adg_fcr.style.display = "none";
                }
            }
        </script>
        {{-- Click btn add ngay nuoi --}}
        <script>
            // Get the modal
            var modal_ngay_nuoi = document.getElementById("myModal_add_ngay_nuoi");
            // Get the button that opens the modal
            var btn = document.getElementById("myBtn_add_ngay_nuoi");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal_ngay_nuoi.style.display = "block";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal_ngay_nuoi) {
                    modal_ngay_nuoi.style.display = "none";
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </section>
@endsection
