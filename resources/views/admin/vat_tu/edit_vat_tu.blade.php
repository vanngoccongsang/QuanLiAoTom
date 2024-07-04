@extends('welcome1')
@section('content')
    <section class="">
            @foreach($edit_vat_tu as $key => $edit_value)
                <form class="modal-content animate" action="{{ URL::to('/update-vat-tu/'.$edit_value->ma_vat_tu) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                          <h3 class="box-title">CHỈNH SỬA VẬT TƯ</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                          <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên vật tư</label>
                                    <input type="text" name="ten_vat_tu" class="form-control" value="{{ $edit_value->ten_vat_tu }}" placeholder="Tên vật tư">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Loại</label>
                                    {{-- <input type="text" name="loai_vat_tu"class="form-control" value="{{ $edit_value->loai_vat_tu }}" placeholder="Loại vật tư"> --}}
                                    <select class="form-control" name="loai_vat_tu" id="" style="height: 43px;">
                                        <option value="{{ $edit_value->loai_vat_tu }}">--{{ $edit_value->loai_vat_tu }}--</option>
                                        <option value="Thức ăn">Thức ăn</option>
                                        <option value="Tôm giống">Tôm giống</option>
                                        <option value="Thuốc khử khuẩn">Thuốc khử khuẩn</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <input type="text" name="mo_ta"class="form-control" value="{{ $edit_value->mo_ta }}" placeholder="Mô tả">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nhà cung cấp</label>
                                    <input type="text" name="nha_cung_cap"class="form-control" value="{{ $edit_value->nha_cung_cap }}" placeholder="Nhà cung cấp">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng nhập</label>
                                    <input type="text" name="so_luong_nhap"class="form-control" value="{{ $edit_value->so_luong_nhap }}" placeholder="Số lượng nhập">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Đơn vị</label>
                                    <input type="text" name="don_vi"class="form-control" value="{{ $edit_value->don_vi }}" placeholder="Đơn vị (vd: kg, con,...)">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Giá vật tư</label>
                                    <input type="number" name="gia_vat_tu"class="form-control" value="{{ $edit_value->gia_vat_tu }}" placeholder="Giá vật tư">
                                </div>
                            </div>
                          <!-- /.box-body -->
                          <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="/all-vat-tu">
                                <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                            </a>
                        </div>
                        </form>
                    </div>
                </form>
            @endforeach
    </section>
@endsection
