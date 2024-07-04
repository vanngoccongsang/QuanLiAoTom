@extends('welcome1')
@section('content')
<section class="trang-chu">
    <main>
        <div class="head-title">
            <div class="box-header" style="text-align: center;color: #3c8dbc;font-family: 'Source Sans Pro';">
                <p style="font-size: 25px;margin: 0px;">TRANG CHỦ</p>
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
        {{-- chỉ số thức ăn  --}}
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <span style="font-size: 20px;">Tổng số lượng tôm giống</span>
                  <p>(Hôm nay)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <p class="small-box-footer" style="font-size: 16px;">{{ number_format($tong_luong_tom) }} con</p>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <span style="font-size: 20px;">Tổng số lượng thức ăn</span>
                  <p>(Hôm nay)</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <p class="small-box-footer" style="font-size: 16px;">{{ number_format($tong_thuc_an) }} kg</p>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <span style="font-size: 20px;">Giá 1kg tôm mới nhất</span>
                  <p>.</p>
                </div>
                <div class="icon">
                   <i class="fa fa-fw fa-balance-scale"></i>
                </div>
                <p class="small-box-footer" style="font-size: 16px;">{{ number_format($new_gia_tom) }} VND</p>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                  <div class="inner">
                    <span style="font-size: 20px;">Tổng chi phí nhập vật tư</span>
                    <p>.</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-fw fa-credit-card"></i>
                  </div>
                  <p class="small-box-footer" style="font-size: 16px;">{{ number_format($chi_phi_vat_tu) }} VND</p>
                </div>
              </div>
        </div>

        <div style="margin-bottom: 10px; justify-content: right; display: flex;">
            <div id="myModal_gia_tom" class="modal">
                <!-- Modal content -->
                    <div class="modal-content">
                        <p class="close-form"
                            style="font-size: 30px;"onclick="document.getElementById('myModal_gia_tom').style.display='none'">&times;</p>
                        <div class="box box-primary">
                            <form class="" action="{{ URL::to('/save-gia-tom') }}" method="post">
                                {{ csrf_field() }}
                                <div class="box-header with-border" style="text-align: center;">
                                    <p class="box-title">Nhập giá tôm</p>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Ngày </label>
                                        <input type="date" name="ngay_ban" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Giá 1kg tôm (VND)</label>
                                        <input type="number" name="gia_ban" class="form-control"
                                            placeholder="Giá 1kg tôm (VND)">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                    <button type="submit" class="btn btn-primary">Lưu giá tôm</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>

        <div class="list-chart">
            <div class="col-sm-6">
                 {{-- chart1 --}}
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Lợi nhuận các ao</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                          <canvas id="lineChart_doanh_thu"></canvas>
                        </div>
                        <div class="title-chart" style="display: flex; grid-gap: 5px;">
                            <p><i class="fa fa-fw fa-circle" style="color: rgb(61, 218, 142)"></i>Lợi nhuận</p>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="col-sm-6">
                {{-- chart2 --}}
                <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Giá tôm</h3>

                      <div class="box-tools pull-right" style="display: flex;">
                        <button type="button" id="myBtn_gia_tom" class="btn btn-block btn-primary" style="width: 110px; background-color: #3bcaba">Nhập giá tôm</button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                          <canvas id="lineChart_gia_tom"></canvas>
                        </div>
                        <div class="title-chart" style="">
                            <p><i class="fa fa-fw fa-circle" style="color: rgb(192, 118, 218)"></i> Giá tôm</p>
                        </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Số lượng</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <div class="box-body">
                        <canvas id="pieChart"></canvas>
                        <div class="title-chart" style="font-size: 14px; margin-top: 55px;">
                            <p class="col-sm-3"><i class="fa fa-fw fa-circle" style="color: #f39c12"></i> Ao nuôi</p>
                            <p class="col-sm-3"><i class="fa fa-fw fa-circle" style="color: #f56954"></i> Khu nuôi</p>
                            <p class="col-sm-3"><i class="fa fa-fw fa-circle" style="color: #00a65a"></i> Vụ nuôi</p>
                            <p class="col-sm-3"><i class="fa fa-fw fa-circle" style="color: #00c0ef"></i> Vật tư</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Vật tư</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <div id="bar-chart-vat-tu" width="auto"></div>
                            <div class="title-chart" style="font-size: 14px;">
                                <p class="col-sm-4"><i class="fa fa-fw fa-circle" style="color: #00a65a"></i>Số lượng nhập</p>
                                <p class="col-sm-4"><i class="fa fa-fw fa-circle" style="color: #f56954"></i>Số lượng tồn</p>
                                <p class="col-sm-4"><i class="fa fa-fw fa-circle" style="color: #87da4e"></i>Giá vật tư (VND)</p>
                            </div>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
        <hr width="100%">
        <div class="list_ao_nuoi" style="margin-top: -15px;">
            <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Danh sách ao nuôi</h3>
                  <div class="box-tools pull-right" style="display: flex;">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    {{-- <button onclick="window.scrollTo(0, 0)" class="btn btn-block btn-primary"
                    style="background-color: #3bcaba"><i class="fa fa-angle-up" aria-hidden="true"></i></button> --}}
                  </div>
                </div>
                @role('admin|quan ly ao')
                <div class="box-body" style="">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                            <form action="" style="margin: 10px;">
                                @csrf
                                <select name="sort" id="sort" class="form-control" style="border: 2px solid #5aa2b4;border-radius: 5px;">
                                    <option value="{{ Request::url() }}?sort_tt=none">--- Chọn trạng thái ---</option>
                                    <option value="{{ Request::url() }}?sort_tt=tat_ca_ao">Tất cả ao</option>
                                    <option value="{{ Request::url() }}?sort_tt=ngung_hoat_dong">Ngừng hoạt động</option>
                                    <option value="{{ Request::url() }}?sort_tt=hoat_dong">Hoạt động</option>
                                    <option value="{{ Request::url() }}?sort_tt=da_ban">Đã bán</option>
                                </select>
                            </form>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                            <form action="" style="margin: 10px;">
                                @csrf
                                <select name="sort_ao" id="sort_ao" class="form-control" style="border: 2px solid #5aa2b4;border-radius: 5px;">
                                    <option value="{{ Request::url() }}?sort_ao=none">--- Chọn ao ---</option>
                                    <option value="{{ Request::url() }}?sort_ao=tat_ca_ao">Tất cả ao</option>
                                    @foreach ($lay_ao_sort as $val)
                                        <option value="{{ Request::url() }}?sort_ao={{ $val->ma_ao }}">{{ $val->ten_ao }}</option>
                                    @endforeach
                                </select>
                            </form>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <form action="" style="margin: 10px;">
                            @csrf
                            <select name="sort_khu" id="sort_khu" class="form-control" style="border: 2px solid #5aa2b4;border-radius: 5px;">
                                <option value="{{ Request::url() }}?sort_khu=none">--- Chọn khu ---</option>
                                <option value="{{ Request::url() }}?sort_khu=tat_ca_ao">Tất cả ao</option>
                                @foreach ($lay_khu_sort as $val)
                                    <option value="{{ Request::url() }}?sort_khu={{ $val->ma_khu }}">{{ $val->ten_khu }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <form action="" style="margin: 10px;">
                            @csrf
                            <select name="sort_vu" id="sort_vu" class="form-control" style="border: 2px solid #5aa2b4;border-radius: 5px;">
                                <option value="{{ Request::url() }}?sort_vu=none">--- Chọn vụ ---</option>
                                <option value="{{ Request::url() }}?sort_vu=tat_ca_ao">Tất cả ao</option>
                                @foreach ($lay_vu_sort as $val)
                                    <option value="{{ Request::url() }}?sort_vu={{ $val->ma_vu }}">{{ $val->ten_vu }}</option>
                                @endforeach
                            </select>
                        </form>
                </div>
                </div>
                <div class="box-body" style="">
                    @foreach ($lay_ds_ao as $value)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                            @if ( $value->trang_thai =='Đã bán')
                                {{-- <span class="info-box-icon bg-aqua" style="border-radius: 45px;background-color: #ffdbdb !important">
                                    @php
                                    $qr_code_url = url('/xuat-lich-su-nuoi/'.$value->ao_cha);
                                    @endphp
                                    <p style="margin-top: 14px;">{{ QrCode::size(63)->generate($qr_code_url) }}</p>
                                </span> --}}
                                <span class="info-box-icon bg-aqua" style="border-radius: 25px;background-color: #ffffff !important">
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#modal-info-{{ $value->ma_ao }}" style="padding: 7px; border-radius: 5px;">QR</button>
                                </span>
                                  <div class="modal modal-info fade" id="modal-info-{{ $value->ma_ao }}" style="display: none;">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                          <h4 class="modal-title">Lịch sử: {{ $value->ten_ao }} - {{ $value->ten_khu }} - {{ $value->ten_vu }}</h4>
                                        </div>
                                        <div class="modal-body" style="text-align: center;background-color: #ffffff !important;">
                                            @php
                                            $qr_code_url = url('/xuat-lich-su-nuoi/'.$value->ao_cha);
                                            @endphp
                                            <p>{{ QrCode::size(200)->generate($qr_code_url) }}</p>
                                        </div>
                                        {{-- <div class="modal-footer">
                                          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Thoát</button>
                                        </div> --}}
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                            @else
                                <span class="info-box-icon bg-aqua" style="border-radius: 45px;">
                                    <i class="fa fa-tint" aria-hidden="true"></i>
                                </span>
                            @endif
                            <div class="info-box-content">
                                <span class="info-box-number" style="font-size: 16px;font-family: Source Sans Pro;">
                                    {{ $value->ten_ao }} - {{ $value->ten_khu }} - {{ $value->ten_vu }}
                                </span>
                                <div class="title-list-ao" style="display:flex;justify-content: space-between;">
                                    <p style="font-size: 14px;">{{ $value->loai_ao }}</p>
                                    @if($value->trang_thai =='')
                                        <span class="label label-danger">Null</span>;
                                    @elseif($value->trang_thai =='Ngừng hoạt động')
                                        <span class="label label-danger">{{ $value->trang_thai }}</span>
                                    @elseif($value->trang_thai =='Hoạt động')
                                    <span class="label label-success">{{ $value->trang_thai }}</span>
                                    @elseif($value->trang_thai =='Đã bán')
                                        <span class="label label-info">{{ $value->trang_thai }}</span>
                                    @else
                                    <span class="label label-warning">{{ $value->trang_thai }}</span>
                                    @endif
                                </div>
                                <div style="justify-content: space-between; display: flex; font-size: 14px;">
                                    <a href="/bao-cao-ao/{{ $value->ma_ao }}/{{ $value->ma_khu }}/{{ $value->ma_vu }}" class="">Xem chi tiết</a>
                                    @if ( $value->trang_thai =='Đã bán')
                                    <a href="/lich-su-nuoi/{{ $value->ao_cha }}">
                                        Xem lịch sử
                                    </a>
                                    @endif
                            </div>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        @endforeach
                </div>
                @endrole
                <!-- /.box-body -->
              </div>
        </div>
    </main>
    <script>
        $(document).ready(function(){
           $('#sort').on('change',function(){
               var url = $(this).val();
               if(url){
                   window.location = url;
               }
               return false;
           });
        });
    </script>
    <script>
        $(document).ready(function(){
           $('#sort_ao').on('change',function(){
               var url = $(this).val();
               if(url){
                   window.location = url;
               }
               return false;
           });
        });
    </script>
    <script>
    $(document).ready(function(){
       $('#sort_vu').on('change',function(){
           var url = $(this).val();
           if(url){
               window.location = url;
           }
           return false;
       });
    });
    </script>
    </script>
    <script>
    $(document).ready(function(){
       $('#sort_khu').on('change',function(){
           var url = $(this).val();
           if(url){
               window.location = url;
           }
           return false;
       });
    });
    </script>
    <script>
        $(function () {
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieChart       = new Chart(pieChartCanvas)
            var PieData        = [
            {
                value    : {{ $count_khu }},
                color    : '#f56954',
                highlight: '#f56954',
                label    : 'Khu nuôi'
            },
            {
                value    : {{ $count_vu }},
                color    : '#00a65a',
                highlight: '#00a65a',
                label    : 'Vụ nuôi'
            },
            {
                value    : {{ $count_ao }},
                color    : '#f39c12',
                highlight: '#f39c12',
                label    : 'Ao nuôi'
            },
            {
                value    : {{ $count_vat_tu }},
                color    : '#00c0ef',
                highlight: '#00c0ef',
                label    : 'Vật tư'
            },
            ]
            var pieOptions     = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke    : true,
            //String - The colour of each segment stroke
            segmentStrokeColor   : '#fff',
            //Number - The width of each segment stroke
            segmentStrokeWidth   : 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps       : 100,
            //String - Animation easing effect
            animationEasing      : 'easeOutBounce',
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate        : true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale         : false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive           : true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio  : true,
            //String - A legend template
            legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            pieChart.Doughnut(PieData, pieOptions)



            //- LINE CHART -doanh thu
            //--------------
            var lineChartCanvas_doanh_thu          = $('#lineChart_doanh_thu').get(0).getContext('2d')
            var lineChart_doanh_thu               = new Chart(lineChartCanvas_doanh_thu)
            var lineChartData_doanh_thu = {
                    labels  : JSON.parse('{!! $ten_ao !!}'),
                    datasets: [
                        {
                        label               : 'Lợi nhuận',
                        fillColor           : 'rgb(61, 218, 142)',
                        strokeColor         : 'rgb(61, 218, 142)',
                        pointColor          : 'rgb(61, 218, 142)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : JSON.parse('{!! $loi_nhuan !!}')
                        },
                    ]
                    }
            // lineChartOptions.datasetFill = false
            lineChart_doanh_thu.Line(lineChartData_doanh_thu, pieOptions)
            //- LINE CHART -gia
            //--------------
            var lineChartCanvas_gia_tom          = $('#lineChart_gia_tom').get(0).getContext('2d')
            var lineChart_gia_tom            = new Chart(lineChartCanvas_gia_tom)
            var lineChartData_gia_tom = {
                    labels  : JSON.parse('{!! $ngay_ban !!}'),
                    datasets: [
                        {
                        label               : 'Giá bán',
                        fillColor           : 'rgb(192, 118, 218)',
                        strokeColor         : 'rgb(192, 118, 218)',
                        pointColor          : 'rgb(192, 118, 218)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : JSON.parse('{!! $gia_ban !!}')
                        },
                    ]
                    }
            // lineChartOptions.datasetFill = false
            lineChart_gia_tom.Line(lineChartData_gia_tom, pieOptions)
        });
    </script>
{{-- Click btn gia tom --}}
<script>
    // Get the modal
    var modal_chiet_tom = document.getElementById("myModal_gia_tom");
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn_gia_tom");
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

        <script>
            var y = <?php echo $bar_ten_vat_tu; ?>;
            var a = <?php echo $bar_so_luong_nhap; ?>;
            var b = <?php echo $bar_so_luong_ton; ?>;
            var c = <?php echo $bar_gia_vat_tu; ?>;
            $(function() {
                var data_vt = [];
                for (var i = 0; i < y.length; i++) {
                    data_vt.push({ y: y[i], a: a[i], b: b[i], c: c[i] });
                }
                //BAR CHART
                var bar = new Morris.Bar({
                element: 'bar-chart-vat-tu',
                resize: true,
                data: data_vt,
                barColors: ['#00a65a', '#f56954', '#87da4e'],
                xkey: 'y',
                ykeys: ['a', 'b', 'c'],
                labels: ['Số lượng nhập','Số lượng tồn','Giá vật tư (VND)'],
                hideHover: 'auto'
                });
            });
        </script>
    <!-- MAIN -->
</section>
@endsection
