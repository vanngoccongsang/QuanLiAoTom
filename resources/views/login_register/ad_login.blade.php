@extends('login_register.main_log_re')
@section('content')

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>Admin</b></a>
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

                <form action="{{ URL::to('/user-login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        {{-- <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label class="">
                                    <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false"
                                        style="position: relative;"><input type="checkbox"
                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                            class="iCheck-helper"
                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div> Remember Me
                                </label>
                            </div>
                        </div> --}}
                        <!-- /.col -->
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                {{-- <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
            Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
            Google+</a>
        </div> --}}
                <!-- /.social-auth-links -->
            <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                <a href="/register" class="text-center">Đăng ký</a>
                {{-- <a href="{{ route('password.request') }}">Quên mật khẩu</a> --}}

            </div>
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
            $(function() {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
            });
        </script>
    </body>
@endsection
