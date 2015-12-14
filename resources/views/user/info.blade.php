@extends('layouts.default')
@section('styles')
    <link href="{{ asset('assets/bootstrap-sco/css/scojs.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/sco.message.css')}}" rel="stylesheet" media="screen">
@stop
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/bootstrap-sco/js/sco.message.js')}}" charset="UTF-8"></script>
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div style="margin-top: 10px;">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="oldpassword">原密码</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="oldpassword" name="oldpassword" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="newpassword">新密码</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="newpassword" name="newpassword" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="repeatpassword">再输一次</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="repeatpassword" name="repeatpassword" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4" style="text-align: right;">
                        <button type="button" class="btn btn-primary" rel="updatepwd">更改密码</button>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="email">邮箱地址</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="email" name="email" placeholder="" value="{{$email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4" style="text-align: right;">
                        <button type="button" class="btn btn-primary" rel="updateemail">更改邮箱</button>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="listrow">列表每页显示</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="listrow" name="listrow" placeholder="" value="{{$listrow}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4" style="text-align: right;">
                        <button type="button" class="btn btn-primary" rel="updatelr">更改行数设置</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("button[rel='updatepwd']").click(function(){
                if($("#oldpassword").val()==""){
                    $.scojs_message("请输入原密码", $.scojs_message.TYPE_ERROR);
                    return;
                }
                if($("#newpassword").val()==""){
                    $.scojs_message("请输入新密码", $.scojs_message.TYPE_ERROR);
                    return;
                }
                if($("#repeatpassword").val()==""){
                    $.scojs_message("请再输入一次密码", $.scojs_message.TYPE_ERROR);
                    return;
                }
                if($("#newpassword").val()!=$("#repeatpassword").val()){
                    $.scojs_message("两次输入密码不符", $.scojs_message.TYPE_ERROR);
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: 'user/updatepwd' ,
                    data: {oldpassword:$("#oldpassword").val(),newpassword:$("#newpassword").val(),_token:Config.token} ,
                    dataType: 'json',
                    success: function(data){
                        if(data.result){
                            $.scojs_message(data.msg, $.scojs_message.TYPE_OK);
                            location.reload();
                        }else{
                            $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                        }
                    }
                });
            });

            $("button[rel='updateemail']").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'user/updateemail' ,
                    data: {email:$("#email").val(),_token:Config.token} ,
                    dataType: 'json',
                    success: function(data){
                        if(data.result){
                            $.scojs_message(data.msg, $.scojs_message.TYPE_OK);
                        }else{
                            $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                        }
                    }
                });
            });

            $("button[rel='updatelr']").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'user/updatelr' ,
                    data: {listrow:$("#listrow").val(),_token:Config.token} ,
                    dataType: 'json',
                    success: function(data){
                        if(data.result){
                            $.scojs_message(data.msg, $.scojs_message.TYPE_OK);
                        }else{
                            $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                        }
                    }
                });
            });

        });
    </script>
@stop