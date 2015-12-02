@extends('layouts.default')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">系统配置</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline">
                <div class="form-group">
                    <label for="formGroupInputLarge">供应商编号</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                    <button type="submit" class="btn btn-default">修改</button>
                </div>
            </form>
            <div style="padding: 10px 0px;"><label>发送邮件配置</label></div>
            <form class="form-inline row">
                <div class="form-group col-sm-3">
                    <label>服务器</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                </div>
                <div class="form-group col-sm-2">
                    <label>端口</label>
                    <input class="form-control" style="width: 100px;" type="text" id="formGroupInputLarge" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>用户名</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>密码</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                </div>
                <div class="form-group col-sm-1">
                    <button type="submit" class="btn btn-default">修改</button>
                </div>
            </form>
            <div style="padding: 10px 0px;"><label>CRM服务器配置</label></div>
            <form class="form-inline row">
                <div class="form-group col-sm-3">
                    <label>服务器</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                </div>
                <div class="form-group col-sm-2">
                    <label>端口</label>
                    <input class="form-control" style="width: 100px;" type="text" id="formGroupInputLarge" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>用户名</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>密码</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                </div>

                <div class="form-group col-sm-11" style="padding: 10px 10px;">
                    <label>超时设置</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                    <label>秒</label>
                </div>
                <div class="form-group col-sm-1">
                    <button type="submit" class="btn btn-default">修改</button>
                </div>
            </form>
            <form class="form-inline row">
                <div class="form-group col-sm-4">
                    <label>列表刷新间隔</label>
                    <input class="form-control" type="text" id="formGroupInputLarge" placeholder="">
                    <label>分</label>
                </div>
                <div class="form-group col-sm-1">
                    <button type="submit" class="btn btn-default">修改</button>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">系统配置</h3>
        </div>
        <div class="panel-body">
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#changeStatus").change(function(){
                location.href = '/user/index/'+$("#changeStatus").val();
            });

            $("button[rel='reset']").click(function(){
                var id = $(this).parents("tr").attr("id");
                $("#upwd_id").val(id);
                $('#modal_upwd').modal('show');
            });

            $("button[rel='leave']").click(function(){
                var id = $(this).parents("tr").attr("id");
                if(confirm("该用户确定离职操作？")){
                    $.ajax({
                        type: 'POST',
                        url: '/user/leave' ,
                        data: {id:id,_token:Config.token} ,
                        dataType: 'json',
                        success: function(){
                            location.reload();
                        }
                    });
                }
            });

            $("#enter_upwd").click(function(){
                var check = true;
                $("#newpassword").parent("div").parent("div").attr("class","form-group");
                if($("#newpassword").val()==''){
                    $("#newpassword").parent("div").parent("div").addClass("has-error has-feedback");
                    $("#newpassword").next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
                    check = false;
                }else{
                    $("#newpassword").parent("div").parent("div").addClass("has-success has-feedback");
                    $("#newpassword").next().attr('class', 'glyphicon glyphicon-ok form-control-feedback');
                }
                if(!check)
                    return;
                $('#upwd_form').ajaxSubmit(function(data){
                    var msg = '';
                    if(data.password){
                        $("#newpassword").parent("div").parent("div").addClass("has-error has-feedback");
                        $("#newpassword").next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
                        msg += data.password;
                    }
                    if(msg!=''){
                        $("#upwd_msg").html('<div class="alert alert-danger" role="alert">'+msg+'</div>');
                        return;
                    }
                    $("#upwd_msg").html('<div class="alert alert-success" role="alert">重置成功</div>');
                    location.reload();
                });
                return false;
            });


            $("#enter").click(function(){
                var isCheck = true;
                $("#name").parent("div").parent("div").attr("class","form-group");
                if($("#name").val()==''){
                    $("#name").parent("div").parent("div").addClass("has-error has-feedback");
                    $("#name").next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
                    isCheck = false;
                }else{
                    $("#name").parent("div").parent("div").addClass("has-success has-feedback");
                    $("#name").next().attr('class', 'glyphicon glyphicon-ok form-control-feedback');
                }
                $("#password").parent("div").parent("div").attr("class","form-group");
                if($("#password").val()==''){
                    $("#password").parent("div").parent("div").addClass("has-error has-feedback");
                    $("#password").next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
                    isCheck = false;
                }else{
                    $("#password").parent("div").parent("div").addClass("has-success has-feedback");
                    $("#password").next().attr('class', 'glyphicon glyphicon-ok form-control-feedback');
                }
                $("#email").parent("div").parent("div").attr("class","form-group");
                var reg = /\w+[@]{1}\w+[.]\w+/;
                if($("#email").val()=='' || !reg.test($("#email").val())){
                    $("#email").parent("div").parent("div").addClass("has-error has-feedback");
                    $("#email").next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
                    isCheck = false;
                }else{
                    $("#email").parent("div").parent("div").addClass("has-success has-feedback");
                    $("#email").next().attr('class', 'glyphicon glyphicon-ok form-control-feedback');
                }
                if(!isCheck)
                    return;
                $('#create_form').ajaxSubmit(function(data){
                    var msg = '';
                    if(data.name){
                        $("#name").parent("div").parent("div").addClass("has-error has-feedback");
                        $("#name").next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
                        msg += data.name;
                    }
                    if(data.email){
                        $("#email").parent("div").parent("div").addClass("has-error has-feedback");
                        $("#email").next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
                        if(msg!='')
                            msg+="<br/>";
                        msg += data.email;
                    }
                    if(msg!=''){
                        $("#msg").html('<div class="alert alert-danger" role="alert">'+msg+'</div>');
                        return;
                    }
                    $("#msg").html('<div class="alert alert-success" role="alert">添加成功</div>');
                    location.reload();
                });
                return false;
            });

        });
    </script>
@stop