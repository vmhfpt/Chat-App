<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->

    <link rel="stylesheet" href="{{ url('Admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('Admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('Admin/dist/css/adminlte.min.css') }}">

</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Đăng nhập</b>Demo chat</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Nghĩ về tương lai, cuộc sống sau lày,
                    con đường mà mình đã chọn ở phía trước còn chông gai !!
                </p>
  {{--action="{{ route('login') }}"--}}
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input value="{{old('email')}}" name="email" type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                    </div>
                    @error('email')
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Cảnh báo !</strong> {{$message}}.
                      </div>
                      @enderror
                    <div class="input-group mb-3">
                        <input value="{{old('password')}}" name="password" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                    </div>
                    @error('password')
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Cảnh báo !</strong> {{$message}}.
                      </div>
                      @enderror
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Ghi nhớ tôi
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </div>

                        <!-- /.col -->
                    </div>
                </form>


                <!-- /.social-auth-links -->


                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        <strong>Cảnh báo!</strong> {!! Session::get('error') !!}.
                    </div>
                @endif
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->

    <script src="{{ url('Admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('Admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ url('Admin/dist/js/adminlte.min.js') }}"></script>

</body>

</html>
