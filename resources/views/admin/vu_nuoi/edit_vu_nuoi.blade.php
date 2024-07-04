@extends('welcome1')
@section('content')
    <section class="">
            @foreach($edit_vu as $key => $edit_value)
                <form class="modal-content animate" action="{{ URL::to('/update-vu/'.$edit_value->ma_vu) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                          <h3 class="box-title">Chỉnh sửa vụ nuôi</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên vụ</label>
                                    <input type="text" name="ten_vu" class="form-control" value="{{ $edit_value->ten_vu }}" placeholder="Mùa vụ">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Ngày tạo</label>
                                    <input type="date" name="ngay_tao"class="form-date" value="{{ $edit_value->ngay_tao }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Ngày bắt đầu</label>
                                    <input type="date" name="ngay_bat_dau"class="form-date" value="{{ $edit_value->ngay_bat_dau }}" placeholder="Ngày bắt đầu">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Ngày kết thúc</label>
                                    <input type="date" name="ngay_ket_thuc"class="form-date" value="{{ $edit_value->ngay_ket_thuc }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Trạng thái</label>
                                    <select class="form-control" name="trang_thai">
                                        <option value="{{ $edit_value->trang_thai }}">--{{ $edit_value->trang_thai }}--</option>

                                        <option value="Hoạt động">Hoạt động</option>
                                        <option value="Ngừng hoạt động">Ngừng hoạt động</option>
                                    </select>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    <a href="/all-vu-nuoi">
                                        <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </form>
            @endforeach
    </section>
@endsection
