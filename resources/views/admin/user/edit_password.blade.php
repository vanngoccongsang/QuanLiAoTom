@extends('welcome1')
@section('content')
    <section class="">
        <form class="modal-content animate" action="{{ URL::to('/update-password/'.$id) }}" method="post">
            {{ csrf_field() }}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">MẬT KHẨU MỚI</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                    <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nhập mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Xác nhận mật khẩu mới</label>
                        <input type="password" name="re_password"class="form-control" placeholder="Xác nhận mật khẩu mới">
                    </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    <a href="">
                        <button type="" class="btn btn-primary">Thoát</button>
                    </a>
                    </div>
                </form>
            </div>
        </form>
    </section>
@endsection
