
@extends('welcome1')
@section('content')
    <section class="">
            @foreach($edit_ao as $key => $edit_value)
                <form class="modal-content animate" action="{{ URL::to('/update-ao/'.$edit_value->ma_ao) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                          <h3 class="box-title">CHỈNH SỬA AO NUÔI</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="form-group">
                                <label for="exampleInputPassword1">Tên ao</label>
                                <input type="text" name="ten_ao" class="form-control" value="{{ $edit_value->ten_ao }}"placeholder="Tên ao">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên khu</label>
                                    <select name="ma_khu" id="">
                                        <option value="{{ $edit_value->ma_khu }}">--{{ $edit_value->ten_khu }}--</option>
                                        @foreach ($khu_nuoi as  $key => $khu)
                                        <option value="{{ $khu->ma_khu }}">{{ $khu->ten_khu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên vụ</label>
                                    <select name="ma_vu" id="">
                                        <option value="{{ $edit_value->ma_vu }}">--{{ $edit_value->ten_vu }}--</option>
                                        @foreach ($vu_nuoi as  $key => $vu)
                                        <option value="{{ $vu->ma_vu }}">{{ $vu->ten_vu }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                  <label for="exampleInputPassword1">Loại ao</label>
                                  <input type="text" name="loai_ao"class="form-control" value="{{ $edit_value->loai_ao }}" placeholder="Loại ao">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Diện tích</label>
                                    <input type="number" name="dien_tich"class="form-control" value="{{ $edit_value->dien_tich }}" placeholder="Diện tích (m²)">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Hình dạng ao</label>

                                <select name="hinh_dang" id="" >
                                    <option value="{{ $edit_value->hinh_dang }}">--{{ $edit_value->hinh_dang }}--</option>
                                    <option value="Ao tròn">Ao tròn</option>
                                    <option value="Ao vuông">Ao vuông</option>
                                </select>
                            </div>
                              <div class="form-group">
                                <label for="exampleInputPassword1">Trạng thái</label>
                                <select name="trang_thai" id="">
                                    <option value="{{ $edit_value->trang_thai }}">--{{ $edit_value->trang_thai }}--</option>
                                    <option value="Ngừng hoạt động">Ngừng hoạt động</option>
                                    <option value="Hoạt động">Hoạt động</option>
                                </select>
                            </div>
                            </div>
                          <!-- /.box-body -->
                            <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="/all-ao-nuoi">
                                    <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                                </a>
                            </div>
                        </div>
                        </form>
                    </div>
                </form>
            @endforeach
    </section>
@endsection
