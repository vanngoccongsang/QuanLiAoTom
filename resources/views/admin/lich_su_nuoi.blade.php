@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table">
            <div class="box-header">
                <p style="font-size: 25px;">LỊCH SỬ NUÔI</p>
                <div style="">
                    @foreach ($lay_thong_tin_ao as $val)
                    <p style="font-size: 18px;color: rgb(255 63 63);">
                        {{ $val->ten_ao }} - {{ $val->ten_khu }} - {{ $val->ten_vu }}
                    </p>
                    {{-- <i class="fa fa-arrows-h" aria-hidden="true" style="font-size: 18px;margin-top: 5px;"></i> --}}
                    @endforeach
                </div>
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
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
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
                <!-- /.box-body -->

            </div>
        </div>
        {{-- Doanh thu --}}
        <div class="callout callout-info">
            <h4 style="text-align: center;">Thông tin khách hàng:</h4>
            @foreach ($lay_khach_hang as $khach)
                <p>Tên: {{ $khach->ten_khach_hang }} ({{ $khach->loai_khach_hang }})</p>
                <p>SĐT: {{ $khach->so_dien_thoai }}</p>
                <p>Địa chỉ: {{ $khach->dia_chi }}</p>
            @endforeach
          </div>
        <div class="row" style="">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tổng tiền bán tôm</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="info-box-number">{{ number_format($doanh_thu) }} VND</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tổng tiền đã chi</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 40%"></div>
                        </div>
                        <span class="info-box-number">{{ number_format($tong_chi) }} VND</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-money" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Lợi nhuận</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 60%"></div>
                        </div>
                        <span class="info-box-number">{{ number_format($loi_nhuan) }} VND</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>
        <div style="margin: 10px;justify-content: flex-end;display: flex;">
            <a href="/xuat-lich-su-nuoi/{{ $ao_cha }}">
                <button type="button" class="btn btn-block btn-warning" style="width: 200px;">Xuất lịch sử nuôi</button>
            </a>
        </div>
        {{-- <div class="box-body" style="overflow-x: scroll;">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row" style="padding: 5px;">
                    <div class="">
                        <table id="table-tong-ao" class="table table-bordered table-striped dataTable"
                            style="width: 100%; font-family: 'Source Sans Pro';
                            font-size: 16px;">
                            <thead>
                                <tr>
                                    <th style="width: 75px;">Ngày</th>
                                    <th>Tuổi</th>
                                    <th>Lượng thức ăn</th>
                                    <th style="width: 70px;">Lượng tôm SP</th>
                                    <th>Size</th>
                                    <th style="width: 100px;">Lượng tôm giống</th>
                                    <th>ADG</th>
                                    <th>FCR</th>
                                    <th style="width: 60px;">Hao hụt</th>
                                    <th style="width: 100px;">Sang/ Chiết</th>
                                    <th>SL nhận/chiết</th>
                                    <th style="width: 110px;">Tiền chi</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                        <script>
                            $(document).ready(function() {
                                var dataTable = $('#table-tong-ao').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    repornSive: true,
                                    ajax: {
                                        url: "{{ route('all.lich_su_nuoi', ['ao_cha' => ".$ao_cha"]) }}"
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
                                    ]
                                });
                                //     $('#form-sub-bao-cao-ao').on('submit', function(e) {
                                //     e.preventDefault();
                                //     dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                // });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <p style="color: rgb(227, 49, 236)"></p>
        </div> --}}
        <div class="box">
            <div class="box-header">
                <h4 class="box-title">Lịch sử nuôi</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body"  style=" overflow: auto;">
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
                                            url: "{{ route('all.lich_su_nuoi', ['ao_cha' => ".$ao_cha"]) }}"
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
                                        ]
                                    });
                                    //     $('#form-sub-bao-cao-ao').on('submit', function(e) {
                                    //     e.preventDefault();
                                    //     dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                    // });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <script>
            var y = <?php echo $bar_ngay; ?>;
            var a = <?php echo $bar_tom_giong; ?>;
            var b = <?php echo $bar_thuc_an; ?>;
            var c = <?php echo $bar_tien_chi; ?>;
            $(function() {
                var data = [];
                for (var i = 0; i < y.length; i++) {
                    data.push({ y: y[i], a: a[i], b: b[i], c: c[i] });
                }
                //BAR CHART
                var bar = new Morris.Bar({
                element: 'bar-chart',
                resize: true,
                data: data,
                barColors: ['#00a65a', '#f56954', '#87da4e'],
                xkey: 'y',
                ykeys: ['a', 'b', 'c'],
                labels: ['Lượng tôm giống (con)', 'Lượng thức ăn (kg)','Tiền chi (VND)'],
                hideHover: 'auto'
                });
            });
        </script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </section>
@endsection
