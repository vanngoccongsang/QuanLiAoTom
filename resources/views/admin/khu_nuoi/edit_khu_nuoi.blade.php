@extends('welcome1')
@section('content')
    <section class="" style="">
            @foreach($edit_khu as $key => $edit_value)
                <div style="display: flex; justify-content: center;">
                    <div class="alert alert-info alert-dismissible" style="width: 90%;background-color: #3c8dbcd1 !important;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4 style="text-align: center;">Thông tin khu</h4>
                        <p>Tên khu: {{ $edit_value->ten_khu }}</p>
                        <p>Địa chỉ: {{ $edit_value->dia_chi }}</p>
                        <p>Trạng thái: {{ $edit_value->trang_thai }}</p>
                    </div>
                </div>
                <form class="modal-content animate" action="{{ URL::to('/update-khu/'.$edit_value->ma_khu) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                          <h3 class="box-title">Chỉnh sửa khu nuôi</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                          <div class="box-body">
                            <div class="form-group">
                              <label for="exampleInputPassword1">Tên khu</label>
                              <input type="text" name="ten_khu" class="form-control" value="{{ $edit_value->ten_khu }}" placeholder="Tên khu">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Địa chỉ khu</label>
                                <input type="text" name="dia_chi"class="form-control" value="{{ $edit_value->dia_chi }}" placeholder="Địa chỉ khu">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Trạng thái</label>
                                <select class="form-control" name="trang_thai">
                                    <option value="{{ $edit_value->trang_thai }}">--{{ $edit_value->trang_thai }}--</option>
                                    <option value="Hoạt động">Hoạt động</option>
                                    <option value="Ngừng hoạt động">Ngừng hoạt động</option>
                                </select>
                            </div>
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="/all-khu-nuoi">
                                <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                            </a>
                        </div>
                        </form>
                    </div>
                </form>
            @endforeach
    </section>
@endsection
