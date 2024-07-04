@extends('welcome1')
@section('content')
    <section class="">
                <form class="modal-content animate" action="{{ URL::to('/save-nhap-vat-tu/'.$ma_vat_tu) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                            <h3 class="box-title">NHẬP VẬT TƯ</h3>
                            @foreach ($lay_vat_tu as $value)
                                <p>{{ $value->ten_vat_tu }} (SL tồn: {{$value->so_luong_ton}} {{ $value->don_vi }})</p>
                            @endforeach
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                          <div class="box-body">
                                {{-- <div class="form-group">
                                    <label for="exampleInputPassword1">Vật tư nhập thêm</label>
                                    <select class="form-control" name="ma_vat_tu" id="" style="height: 43px;">
                                        <option value="">--Chọn vật tư nhập thêm--</option>
                                        @foreach ($lay_vat_tu as $value)
                                            <option value="{{ $value->ma_vat_tu }}">{{ $value->ten_vat_tu }} (Kho còn {{ number_format($value->so_luong_ton)}} {{ $value->don_vi }})</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Ngày nhập</label>
                                    <input type="date" name="ngay_nhap"class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng nhập</label>
                                    <input type="number" name="so_luong_nhap"class="form-control" placeholder="Số lượng nhập">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Giá tiền</label>
                                    <input type="number" name="gia_tien"class="form-control" placeholder="Giá tiền">
                                </div>
                            </div>
                          <!-- /.box-body -->
                          <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Nhập vật tư</button>
                            <a href="/all-vat-tu">
                                <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                            </a>
                        </div>
                        </form>
                    </div>
                </form>
    </section>
@endsection
