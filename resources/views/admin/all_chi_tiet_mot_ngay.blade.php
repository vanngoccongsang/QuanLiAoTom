@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table">
            <div class="box-header">
                <p style="font-size: 25px;">CHI TIẾT NGÀY NUÔI</p>
            </div>
            {{-- <div class="group-btn" style="margin-bottom: 10px;">
                <form action="{{ URL::to('/loc-bao-cao-ao') }}" method="get" id="form-sub-bao-cao-ao" style="">
                    {{ csrf_field() }}
                    <div class="ao" style="display: flex; grid-gap: 5px;">

                        <div class="ao">

                            <select name="ao_lay_ao_loc" value="" style="width: 100px;">
                                <option value="">Chọn ao</option>
                                @foreach ($ao_nuoi as $ao)
                                    <option value="{{ $ao->ma_ao }}">{{ $ao->ten_ao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="khu">

                            <select name="ao_lay_khu_loc" value="" style="width: 100px;">
                                <option value="">Chọn khu</option>
                                @foreach ($khu_nuoi as $khu)
                                    <option value="{{ $khu->ten_khu }}">{{ $khu->ten_khu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="vu">

                            <select name="ao_lay_vu_loc" value="" style="width: 100px;">
                                <option value="">Chọn vụ</option>
                                @foreach ($vu_nuoi as $vu)
                                    <option value="{{ $vu->ten_vu }}">{{ $vu->ten_vu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-sub-loc">Lọc</button>

                    </div>
                </form>
            </div> --}}
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
        <div class="box-body" style="padding: 15px;">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="">
                        <div class="box box-widget widget-user-2">
                            @foreach ($lay_chi_tiet as $value)
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow" style="background-color: #3c8dbc !important;">
                                <!-- /.widget-user-image -->
                                <div class="head">
                                    <h3 class="widget-user-username">{{ $ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }}</h3>
                                    <h5 class="widget-user-desc" style="font-size: 22px;">
                                        {{ Carbon\Carbon::parse($value->ngay)->format('d/m/Y') }}
                                    </h5>
                                </div>
                                <div style="display: flex; justify-content: right;">
                                    <a href="/bao-cao-ao/{{ $ma_ao }}/{{ $ma_khu }}/{{ $ma_vu }}">
                                        <button class="btn btn-block btn-primary" style="width: 150px; background-color: rgb(224, 123, 123)">Xem báo cáo</button>
                                    </a>
                                </div>
                            </div>
                              <div class="box-footer no-padding">
                                  <div class="list-cu-nuoi">
                                      <div class="box box-success">
                                          <div class="box-header with-border">
                                              <h3 class="box-title">Thông tin ngày nuôi</h3>
                                              <div class="box-tools pull-right">
                                                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                          class="fa fa-minus"></i>
                                                  </button>
                                                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                              </div>
                                          </div>
                                          <div class="box-body" style="">
                                                <div class="list-thong-tin-ao">
                                                    <div class="thong-tin-details">
                                                        <p>Tuổi tôm:</p><span>{{ $value->tuoi_tom }} ngày</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Lượng thức ăn:</p><span>{{ number_format($value->luong_thuc_an) }} kg</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Lượng tôm giống:</p><span>{{ number_format($value->luong_tom_giong) }} con</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Lượng tôm si phong:</p><span> {{ number_format($value->luong_tom_sp) }} gram</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>ADG:</p><span>{{ $value->ADG }}</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>FCR:</p><span>{{ $value->FCR }}</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Size:</p><span>{{ $value->size }}</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Hao hụt:</p><span>{{ number_format($value->hao_hut) }} con</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Tình trạng:</p><span>{{ $value->tinh_trang }}</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Số lượng nhận/chiết:</p><span>{{ number_format($value->sl_nhan_chiet) }} con</span>
                                                    </div>
                                                    <div class="thong-tin-details">
                                                        <p>Số tiền đã chi hôm nay:</p><b style="color: #d53838;">{{ number_format($value->tong_tien) }} VND</b>
                                                    </div>
                                              </div>
                                          </div>
                                          <!-- /.box-body -->
                                      </div>
                                  </div>
                              </div>
                            @endforeach
                        </div>
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Thông số môi trường</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            @foreach ($lay_chi_tiet as $value)
                                @if ($lay_trang_thai != "Đã bán" && $lay_trang_thai != "Ngừng hoạt động")
                                    @if($value->ngay == $max_ngay)
                                        @if($check_moi_truong == null)
                                            <div style="justify-content: end; display: flex; margin-right: 10px;">
                                                @can('add.moi.truong')
                                                    <button type="button" id="myBtn_MT" class="btn btn-block btn-primary"
                                                    style="width: 150px; background-color: #00a65a">Thêm môi trường</button>
                                                @endcan
                                            </div>
                                        @elseif($check_moi_truong != null)
                                            <div style="justify-content: end; display: flex; margin-right: 10px;">
                                                {{-- @can('add.moi.truong') --}}
                                                    @foreach ($lay_chi_tiet as $val)
                                                    <a href="/edit-moi-truong/{{ $val->id_moi_truong }}">
                                                        <button type="button" class="btn btn-block btn-primary"
                                                        style="width: 150px; background-color: #cd5242">Sửa môi trường</button>
                                                    </a>
                                                    @endforeach
                                                {{-- @endcan --}}
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                            <!-- /.box-header -->
                            <div class="box-body" style="">
                                <div class="table-responsive1">
                                    <div class="row">
                                        @foreach ($lay_chi_tiet as $val)
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-red">
                                                    <span class="info-box-icon"><i class="fa fa-thermometer-empty"aria-hidden="true"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text" style="text-transform: none;">Nồng độ pH</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="info-box-number" style="font-size: 25px;">{{ $val->do_ph }} mg/L</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-yellow">
                                                    <span class="info-box-icon"><i class="fa fa-sun-o"
                                                            aria-hidden="true"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Nhiệt độ không khí sáng</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="info-box-number" style="font-size: 25px;">{{ $value->to_khong_khi_sang }} °C</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-yellow">
                                                    <span class="info-box-icon"><i class="fa fa-sun-o"
                                                            aria-hidden="true"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Nhiệt độ Không khí chiều</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span
                                                            class="info-box-number" style="font-size: 25px;">{{ $value->to_khong_khi_chieu }} °C</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-green">
                                                    <span class="info-box-icon"><i class="fa fa-thermometer-three-quarters"
                                                            aria-hidden="true"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Nồng độ Kiềm</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="info-box-number" style="font-size: 25px;">{{ $val->do_kiem }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-aqua">
                                                    <span class="info-box-icon"><i class="fa fa-tint"
                                                            aria-hidden="true"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text"> Nhiệt độ Nước sáng</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="info-box-number" style="font-size: 25px;">{{ $value->to_nuoc_sang }} °C</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-aqua">
                                                    <span class="info-box-icon"><i class="fa fa-tint"
                                                            aria-hidden="true"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Nhiệt độ Nước chiều</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="info-box-number" style="font-size: 25px;">{{ $value->to_nuoc_chieu }} °C</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                        </div>
                        <div id="myModal_MT" class="modal">
                            <!-- Modal content -->
                                <div class="modal-content">
                                    <p class="close-form"
                                        style="font-size: 30px;"onclick="document.getElementById('myModal_MT').style.display='none'">&times;</p>
                                    <div class="box box-primary">

                                        <form class="" action="{{ URL::to('/save-moi-truong/'.$id_ct) }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="box-header with-border" style="text-align: center;">
                                                <p class="box-title">THÊM CHỈ SỐ MÔI TRƯỜNG</p>
                                                <p style="color: rgb(224, 73, 73)">{{ $ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }} - {{ Carbon\Carbon::parse($value->ngay)->format('d/m/Y') }}</p>
                                            </div>
                                            <!-- /.box-header -->
                                            <!-- form start -->
                                                <div class="box-body" style="display: grid;">
                                                    <input type="hidden" name="id_chi_tiet_ao" value="{{ $id_ct }}">
                                                    <div class="form-group">
                                                        <label style="color: black;" for="">Độ kiềm (mg/L) <span style="color: red">*</span></label>
                                                        <input style="width: 100%;"name="do_kiem" type="number" class="form-control" placeholder="Độ kiềm (mg/L)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="color: black;" for="">Độ pH <span style="color: red">*</span></label>
                                                        <input style="width: 100%;" name="do_ph" type="number" step="any" class="form-control" placeholder="Độ pH">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="color: black;" for="">Nhiệt độ không khí sáng (°C) <span style="color: red">*</span></label>
                                                        <input style="width: 100%;" name="to_khong_khi_sang" type="number" class="form-control"
                                                        placeholder="Nhiệt độ không khí sáng (°C)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="color: black;" for="exampleInputEmail1">Nhiệt độ không khí chiều (°C) <span style="color: red">*</span></label>
                                                        <input style="width: 100%;" name="to_khong_khi_chieu" type="number" class="form-control"
                                                        placeholder="Nhiệt độ không khí chiều (°C)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="color: black;" for="exampleInputEmail1">Nhiệt độ nước sáng (°C) <span style="color: red">*</span></label>
                                                        <input style="width: 100%;" name="to_nuoc_sang" type="number" class="form-control" placeholder="Nhiệt độ nước sáng (°C)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="color: black;" for="exampleInputEmail1">Nhiệt độ nước chiều (°C) <span style="color: red">*</span></label>
                                                        <input style="width: 100%;" name="to_nuoc_chieu" type="number" class="form-control"
                                                        placeholder="Nhiệt độ nước chiều (°C)">
                                                    </div>
                                                </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                                <button type="submit" class="btn btn-primary">Thêm môi trường</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                        </div>
                        <div id="myModal_NK" class="modal">
                            <!-- Modal content -->
                                <div class="modal-content">
                                    <p class="close-form"
                                        style="font-size: 30px;"onclick="document.getElementById('myModal_NK').style.display='none'">&times;</p>
                                    <div class="box box-primary">
                                        <form class="" action="{{ URL::to('/save-nhat-ky/'.$id_ct) }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="box-header with-border" style="text-align: center;">
                                                <p class="box-title">THÊM NHẬT KÝ NUÔI</p>
                                                <p style="color: rgb(224, 73, 73)">{{ $ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }} - {{ Carbon\Carbon::parse($value->ngay)->format('d/m/Y') }}</p>
                                            </div>
                                            <!-- /.box-header -->
                                            <!-- form start -->
                                            <div class="box-body" style="display: grid;">
                                                <input type="hidden" name="id_chi_tiet_ao" value="{{ $id_ct }}">
                                                <div class="form-group">
                                                    <label style="color: black;">Tên cử <span style="color: red">*</span></label>
                                                    <input style="width: 100%;" name="ten_cu" type="text" class="form-control" placeholder="Tên cử">
                                                </div>
                                                <div class="form-group">
                                                    <label style="color: black;">Tên vật tư <span style="color: red">*</span></label>
                                                    <select name="ma_vat_tu" style="color: black;width: 100%;">
                                                        @foreach ($vat_tu as $value)
                                                            <option value="{{ $value->ma_vat_tu }}">{{ $value->ten_vat_tu }} (Kho còn {{ number_format($value->so_luong_ton)}} {{ $value->don_vi }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label style="color: black;">Số lượng <span style="color: red">*</span></label>
                                                    <input style="width: 100%;" name="so_luong" type="number" class="form-control" placeholder="Số lượng">
                                                </div>
                                                <div class="form-group">
                                                    <label style="color: black;">Ghi chú (null)</label>
                                                    <input style="width: 100%;" name="ghi_chu" type="text" class="form-control" placeholder="Ghi chú (Null)">
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                                <button type="submit" class="btn btn-primary">Thêm nhật ký</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                        <hr width="100%" style="color: #cd7777">
                        <div class="list-cu-nuoi">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Danh sách cử nuôi</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                @foreach ($lay_chi_tiet as $value)
                                @if ($lay_trang_thai != "Đã bán" && $lay_trang_thai != "Ngừng hoạt động")
                                    @if($value->ngay == $max_ngay)
                                        <div style="justify-content: end; display: flex; margin-right: 10px;">
                                            @can('add.nhat.ky')
                                                <button type="button" id="myBtn_NK" class="btn btn-block btn-primary"
                                                style="width: 150px; background-color: #673ab7">Thêm nhật ký</button>
                                            @endcan
                                        </div>
                                    @endif
                                @endif
                                @endforeach
                                <div class="box-body" style="">
                                    @foreach ($lay_nhat_ky as $value)
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-aqua" style="border-radius: 50px;">
                                                    <p class="info-box-number" style="font-size: 18px;">{{ $value->ten_cu }}</p>
                                                    {{-- <i class="fa fa-fw fa-hourglass-end"></i> --}}
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text" style="text-transform: none;font-size: 17px;">
                                                        Loại: {{ $value->ten_vat_tu }}
                                                    </span>
                                                    <span class="info-box-text">SL: {{ $value->so_luong }} ({{ $value->don_vi }})</span>
                                                    <span class="label label-danger">{{ number_format($value->gia_tien)}} VND</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                    @endforeach
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        {{-- <script>
                            $(document).ready(function() {
                                var dataTable = $('#table-tong-ao').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    repornSive: true,
                                    ajax: {

                                        url: "{{ route('all.all_chi_tiet_mot_ngay', ['ma_ao' => ".$ma_ao.", 'ten_khu' => ".$ten_khu.", 'ten_vu' => ".$ten_vu.", 'ngay' => ".$ngay."]) }}"

                                    },
                                    columns: [
                                        //    {
                                        //         data: 'TT',
                                        //         name: 'TT'
                                        //     },
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
                                            data: 'luong_tom_giong',
                                            name: 'luong_tom_giong'
                                        },
                                        {
                                            data: 'nhiet_do_khi',
                                            name: 'nhiet_do_khi'
                                        },
                                        {
                                            data: 'nhiet_do_nuoc',
                                            name: 'nhiet_do_nuoc'
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
                                            data: 'size',
                                            name: 'size'
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
                                            data: 'Action',
                                            name: 'Action'
                                        },
                                    ]
                                });
                                //     $('#form-sub-bao-cao-ao').on('submit', function(e) {
                                //     e.preventDefault();
                                //     dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                // });
                            });
                        </script> --}}
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Get the modal
            var modal_MT = document.getElementById("myModal_MT");
            // Get the button that opens the modal
            var btn = document.getElementById("myBtn_MT");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal_MT.style.display = "block";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal_MT) {
                    modal_MT.style.display = "none";
                }
            }
        </script>
        <script>
            // Get the modal
            var modal_NK = document.getElementById("myModal_NK");
            // Get the button that opens the modal
            var btn = document.getElementById("myBtn_NK");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal_NK.style.display = "block";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal_NK) {
                    modal_NK.style.display = "none";
                }
            }
        </script>
    </section>

@endsection
