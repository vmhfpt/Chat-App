
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->

    <link rel="stylesheet" href="{{ url('Admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('Admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('Admin/dist/css/adminlte.min.css') }}">
    <script src="{{ url('Admin/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
    </script>
</head>

<body class="hold-transition login-page">
    @auth
        <h1> {{ Auth::user()->name }}</h1>
    @endauth

    <div class="col-md-3">
        <!-- DIRECT CHAT PRIMARY -->
        <div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none">
            <div class="card-header">
                <h3 class="card-title">{{$infor->name}}</h3>

                <div class="card-tools">
                    <span title="3 New Messages" class="badge bg-primary"></span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                    <!-- ----------------------------------------------------------------->

                    @foreach ($dataChat as $value)
                        @if (Auth::user()->id == $value->user_id)
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">{{ $value->getUser->name }}</span>
                                    <span class="direct-chat-timestamp float-left">{{ $value->date }}</span>
                                </div>

                                <img class="direct-chat-img" src=" {{ $value->getUser->avatar }}"
                                    alt="Message User Image">

                                <div class="direct-chat-text">
                                    {{ $value->content }}
                                </div>
                            </div>
                        @else
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ $value->getUser->name }}</span>
                                    <span class="direct-chat-timestamp float-right">{{ $value->date }}</span>
                                </div>
                                <img class="direct-chat-img" src="  @auth
                                        {{ $value->getUser->avatar }}
                        @endauth" alt="Message User Image">
                                <div class="direct-chat-text">
                                    {{ $value->content }}
                                </div>
                            </div>
                        @endif
                    @endforeach


                    <!-- ---------------------------------------------------- -->
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">

                <div class="input-group">
                    <input id="enter-comment" type="text" name="message" placeholder="Aa ..." class="form-control" />
                    <span class="input-group-append">
                        <button type="button" class="send btn btn-primary">Gửi</button>
                    </span>
                </div>

            </div>
            <!-- /.card-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <script>
          $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
        let ip_address = '127.0.0.1';
        let socket_port = '3000';
        let socket = io(ip_address + ':' + socket_port);
        var current = {{ Auth::user()->id }};
        var name = '';
        $('#enter-comment').keyup(function(e) {
            name = e.target.value;
            if (e.which == 13) {
                $('#enter-comment').val('');
                if(name !== ''){
                    var url = '/post-chat';
                $.ajax({
                    url: url,
                    data: {
                        comment: name
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(result) {

                        var user_id = result.user_id;
                        socket.emit('manageChatServer', user_id, name, result.avatar, result.name,
                            result.date);
                            name = '';

                            return false;
                    },
                });
                }


            }
        });
        $('.send').click(function() {
            var url = '/post-chat';
            $('#enter-comment').val('');
            if(name !== ''){
                $.ajax({
                    url: url,
                    data: {
                        comment: name
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(result) {
                        var user_id = result.user_id;
                        socket.emit('manageChatServer', user_id, name, result.avatar, result.name,
                            result.date);
                            name = '';
                            return false;
                    },
                });
            }

        });
        socket.on('manageChatClient', (user_id, message, avatar, name, date) => {

            if (current == user_id) {

                $('.direct-chat-messages').append(` <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">${name}</span>
                                    <span class="direct-chat-timestamp float-left">${date}</span>
                                </div>

                                <img class="direct-chat-img" src="${avatar}"
                                    alt="Message User Image">

                                <div class="direct-chat-text">
                                    ${message}
                                </div>
                            </div>`);
                            $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
            } else {

                $('.direct-chat-messages').append(` <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">${name}</span>
                                    <span class="direct-chat-timestamp float-right">${date}</span>
                                </div>
                                <img class="direct-chat-img" src="${avatar}" alt="Message User Image">
                                <div class="direct-chat-text">
                                    ${message}
                                </div>
                            </div>`);
                            $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
            }

        });
        socket.on('chatOnline', (online) => {
           // console.log(online);
            if(online == 1){
                $('.badge').html("Không hoạt động");
                $('.badge').removeClass('bg-primary');
                $('.badge').addClass('bg-danger');
            }else {
                $('.badge').html("Đang hoạt động");
                $('.badge').removeClass('bg-danger');
                $('.badge').addClass('bg-primary');
            }
        });
    </script>


    <script src="{{ url('Admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ url('Admin/dist/js/adminlte.min.js') }}"></script>

</body>

</html>
