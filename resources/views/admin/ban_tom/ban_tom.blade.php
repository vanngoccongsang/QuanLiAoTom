@extends('welcome1')
@section('content')
    <section>
        <div class="box-header" style="text-align: center;color: #3c8dbc;font-family: 'Source Sans Pro';">
            <p style="font-size: 25px;margin: 0px;">BÁN TÔM</p>
        </div>
        <div class="list_ao_nuoi">
            <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Danh sách ao nuôi</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                @role('admin|quan ly ao')
                <div class="box-body" style="">
                    {{-- <div class="col-md-3 col-sm-6 col-xs-12">
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
                </div> --}}
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
                                    <span class="info-box-icon bg-aqua" style="border-radius: 45px;background-color: #ffdbdb !important">
                                        @php
                                        $qr_code_url = url('/xuat-lich-su-nuoi/'.$value->ao_cha);
                                        @endphp
                                        <p style="margin-top: 14px;">{{ QrCode::size(63)->generate($qr_code_url) }}</p>
                                    </span>
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
                                    <p style="font-size: 14px">{{ $value->loai_ao }}</p>
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
                                <div style="justify-content: space-between; display: flex;">
                                    @if ( $value->trang_thai =='Ngừng hoạt động')
                                        <a href="/bao-cao-ao/{{ $value->ma_ao }}/{{ $value->ma_khu }}/{{ $value->ma_vu }}" class="">Xem chi tiết</a>
                                    @endif
                                    @if ( $value->trang_thai =='Đã bán')
                                    <a href="/bao-cao-ao/{{ $value->ma_ao }}/{{ $value->ma_khu }}/{{ $value->ma_vu }}" class="">Xem chi tiết</a>
                                    <a href="/lich-su-nuoi/{{ $value->ao_cha }}">
                                        Xem lịch sử
                                    </a>
                                    @endif
                                    @if ( $value->trang_thai =='Hoạt động')
                                    <a href=""></a>
                                    <a href="/bao-cao-ao/{{ $value->ma_ao }}/{{ $value->ma_khu }}/{{ $value->ma_vu }}">
                                        <button type="button" class="btn btn-block btn-warning btn-xs" style="width: 100px">Bán tôm</button>
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
    </section>
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
@endsection
