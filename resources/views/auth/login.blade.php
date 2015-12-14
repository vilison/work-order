<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>农行工单管理系统</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-3.3.5/css/bootstrap.css')}}">
    <script src="{{ asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.form.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bootstrap-3.3.5/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script>
        Config = {
            'token': '{{csrf_token()}}'
        };
    </script>
    <link href="{{ asset('assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/scojs.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/sco.message.css')}}" rel="stylesheet" media="screen">
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-sco/js/sco.message.js')}}" charset="UTF-8"></script>
    <style type="text/css">
        .warp {
            width: 300px;
            margin: 0px auto;
            margin-top: 200px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $("button[rel='login']").click(function(){
                if($("#name").val()==""){
                    $.scojs_message("请输入用户名", $.scojs_message.TYPE_ERROR);
                    return;
                }
                if($("#password").val()==""){
                    $.scojs_message("请输入密码", $.scojs_message.TYPE_ERROR);
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '/auth/login' ,
                    data: {name:$("#name").val(),password:$("#password").val(),_token:Config.token} ,
                    dataType: 'json',
                    success: function(data){
                        if(data.result){
                            $.scojs_message(data.msg, $.scojs_message.TYPE_OK);
                            location.href = data.url;
                        }else{
                            $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                        }
                    }
                });
            });
        });
    </script>
</head>

<body>
<div class="warp">
    <h1>农行工单管理系统</h1>
<form id="loginForm" method="POST" action="/auth/login">
    {!! csrf_field() !!}
    <div class="form-group">
        <input class="form-control" type="text" name="name" id="name" placeholder="用户名">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="password" id="password" placeholder="密码">
    </div>
    <div class="form-group" style="text-align: right;">
        <button class="btn btn-primary" type="button" rel="login"> 登录 </button>
    </div>
</form>
</div>
</body>
</html>
