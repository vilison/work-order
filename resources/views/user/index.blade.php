@extends('layouts.default')
@section('content')
<form class="form-horizontal">
    <div class="form-group">
        <div class="col-sm-2">
        <select id="changeStatus" class="form-control">
            <option value="0" {{$status==0?'selected':''}}>全部</option>
            <option value="1" {{$status==1?'selected':''}}>在职</option>
            <option value="2" {{$status==2?'selected':''}}>离职</option>
        </select>
        </div>
    </div>
</form>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>登录名</th>
        <th>邮箱</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @if(count($users))
        @foreach($users as $u)
    <tr id="{{$u->id}}">
        <th scope="row">
            @if($u->status==2)
            <span style="display: inline-block;padding: 5px;background:red;"></span>
            @endif
        </th>
        <td>{{$u->name}}</td>
        <td>{{$u->email}}</td>
        <td>
            @if($u->isadmin==0)
            <button rel="reset" type="button" class="btn btn-default btn-xs">重置密码</button>
            @if($u->status==1)
            <button rel="leave" type="button" class="btn btn-danger btn-xs">离职</button>
            @endif
            @endif
        </td>
    </tr>
    @endforeach
    @endif
    </tbody>
</table>
<p>
<div class="modal fade" id="modal_upwd" tabindex="-1" role="dialog" aria-labelledby="modal_upwdLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">重置密码</h4>
            </div>
            <div class="modal-body">
                <div id="upwd_msg"></div>
                <form id="upwd_form" class="form-horizontal" action="user/upwd" method="post">
                    <input type="hidden" id="upwd_id" name="id" value="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="newpassword" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="newpassword" name="password" placeholder="">
                            <span aria-hidden="true"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="enter_upwd" type="button" class="btn btn-primary">确认</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">新增用户</button>
    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">新增用户</h4>
            </div>
            <div class="modal-body">
                <div id="msg">

                </div>
                <form id="create_form" class="form-horizontal" action="user/store" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">登录名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="" >
                            <span aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password" placeholder="">
                            <span aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="">
                            <span aria-hidden="true"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="enter" type="button" class="btn btn-primary">确认</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
</p>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#changeStatus").change(function(){
                location.href = 'user/index/'+$("#changeStatus").val();
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
                        url: 'user/leave' ,
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