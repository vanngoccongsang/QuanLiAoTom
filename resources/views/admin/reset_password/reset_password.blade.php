@extends('login_register.main_log_re')
@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Lấy lại mật khẩu</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg" style="">
            <div class="message" style="text-align: center;color: #ff6a6a;">
                <?php
                    use Illuminate\Support\Facades\Session;
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="thong-bao-mess">', $message . '</span>';
                        Session::put('message', null);
                    }
                ?>
            </div>
        </p>
        <form action="{{ route('password.email') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Gửi liên kết đặt lại mật khẩu</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });
    </script>
</body>
@endsection
