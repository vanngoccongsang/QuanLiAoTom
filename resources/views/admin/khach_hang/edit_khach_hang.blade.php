@extends('welcome1')
@section('content')
    <section class="">
            @foreach($edit_khach_hang as $key => $edit_value)
                <form class="modal-content animate" action="{{ URL::to('/update-khach-hang/'.$edit_value->id_khach_hang) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                          <h3 class="box-title">Chỉnh sửa khách hàng</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                          <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Loại khách hàng</label>
                                <select class="form-control" name="loai_khach_hang" id="" style="">
                                    <option value="{{ $edit_value->loai_khach_hang }}">--{{ $edit_value->loai_khach_hang }}--</option>
                                    <option value="Tư nhân">Tư nhân</option>
                                    <option value="Chợ">Chợ</option>
                                    <option value="Nhà hàng">Nhà hàng</option>
                                    <option value="Công ty chế biến thực phẩm">Công ty chế biến thực phẩm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tên khách hàng</label>
                                <input type="text" name="ten_khach_hang" class="form-control" value="{{ $edit_value->ten_khach_hang }}" placeholder="Tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số điện thoại</label>
                                <input type="number" name="so_dien_thoai" class="form-control" value="{{ $edit_value->so_dien_thoai }}" placeholder="Số điện thoại">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Địa chỉ</label>
                                <input type="text" name="dia_chi"class="form-control" value="{{ $edit_value->dia_chi }}" placeholder="Địa chỉ">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ghi chú</label>
                                <input type="text" name="ghi_chu"class="form-control" value="{{ $edit_value->ghi_chu }}" placeholder="Ghi chú">
                            </div>
                          <!-- /.box-body -->
                          <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="/all-khach-hang">
                                <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                            </a>
                        </div>
                        </form>
                    </div>
                </form>
            @endforeach
    </section>
@endsection
