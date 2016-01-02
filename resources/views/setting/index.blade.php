@extends('layouts.default')
@section('title')
    系统配置
@stop
@section('styles')
    <link href="{{ asset('assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/scojs.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/sco.message.css')}}" rel="stylesheet" media="screen">
@stop
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-sco/js/sco.message.js')}}" charset="UTF-8"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#date').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
        });
    </script>
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">系统配置</h3>
        </div>
        <div class="panel-body">
            <form id="form_usn" class="form-inline" action="usn" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group">
                    <label for="supplier_number">供应商编号</label>
                    <input class="form-control" type="text" id="supplier_number" name="supplier_number" value="{{$setting->supplier_number}}" placeholder="">
                    <button type="button" class="btn btn-default" rel="usn">修改</button>
                </div>
            </form>
            <div style="padding: 10px 0px;"><label>发送邮件配置</label></div>
            <form class="form-inline row" id="form_usend" action="usend" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group col-sm-3">
                    <label>服务器</label>
                    <input class="form-control" type="text" id="mail_server" name="mail_server" value="{{$setting->mail_server}}" placeholder="">
                </div>
                <div class="form-group col-sm-2">
                    <label>端口</label>
                    <input class="form-control" style="width: 100px;" type="text" id="mail_server_port" name="mail_server_port" value="{{$setting->mail_server_port}}" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>用户名</label>
                    <input class="form-control" type="text" id="mail_account" name="mail_account" value="{{$setting->mail_account}}" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>密码</label>
                    <input class="form-control" type="text" id="mail_password" name="mail_password" value="{{$setting->mail_password}}" placeholder="">
                </div>
                <div class="form-group col-sm-1">
                    <button type="button" class="btn btn-default" rel="usend">修改</button>
                </div>
            </form>
            <div style="padding: 10px 0px;"><label>CRM服务器配置</label></div>
            <form class="form-inline row" id="form_ucrm" action="ucrm" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group col-sm-3">
                    <label>服务器</label>
                    <input class="form-control" type="text" id="crm_server" name="crm_server" value="{{$setting->crm_server}}" placeholder="">
                </div>
                <div class="form-group col-sm-2">
                    <label>端口</label>
                    <input class="form-control" style="width: 100px;" type="text" id="crm_server_port" name="crm_server_port" value="{{$setting->crm_server_port}}" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>用户名</label>
                    <input class="form-control" type="text" id="crm_account" name="crm_account" value="{{$setting->crm_account}}" placeholder="">
                </div>
                <div class="form-group col-sm-3">
                    <label>密码</label>
                    <input class="form-control" type="text" id="crm_password" name="crm_password" value="{{$setting->crm_password}}" placeholder="">
                </div>

                <div class="form-group col-sm-11" style="padding: 20px 10px;">
                    <label>超时设置</label>
                    <input class="form-control" type="text" id="timeout" name="timeout" value="{{$setting->timeout}}" placeholder="">
                    <label>秒</label>
                </div>
                <div class="form-group col-sm-1" style="padding-top: 20px;">
                    <button type="button" class="btn btn-default" rel="ucrm">修改</button>
                </div>
            </form>
            <form class="form-inline row" id="form_utime" action="utime" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group col-sm-12">
                    <label>列表刷新间隔</label>
                    <input class="form-control" type="text" id="refresh_interval" name="refresh_interval" value="{{$setting->refresh_interval}}" placeholder="">
                    <label>分</label>
                </div>
                <div class="form-group col-sm-4" style="padding-top: 20px;">
                    <label>预警超时时间</label>
                    <input class="form-control" type="text" id="warn_timeout" name="warn_timeout" value="{{$setting->warn_timeout}}" placeholder="">
                    <label>分</label>
                </div>
                <div class="form-group col-sm-8" style="padding-top: 20px;">
                    <button type="button" class="btn btn-default" rel="utime">修改</button>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">农行服务器列表</h3>
        </div>
        <div class="panel-body">
            @if(count($nhservers))
                @foreach($nhservers as $nhserver)
                    <form class="form-inline row" style="margin-bottom: 10px;">
                        <input class="form-control" type="hidden" id="id" value="{{$nhserver->id}}" placeholder="">
                        <div class="form-group col-sm-1"></div>
                        <div class="form-group col-sm-3">
                            <label>服务器</label>
                            <input class="form-control" type="text" id="host" value="{{$nhserver->host}}" placeholder="">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>端口</label>
                            <input class="form-control" style="width: 100px;" type="text" id="port" value="{{$nhserver->port}}" placeholder="">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>所在省</label>
                            <input class="form-control" type="text" id="province" value="{{$nhserver->province}}" placeholder="">
                        </div>
                        <div class="form-group col-sm-1">
                            <button type="button" class="btn btn-primary" rel="unserver">修改</button>
                        </div>
                    </form>
                @endforeach
            @endif
            <div style="background: #f5f5f5; padding-top:10px;padding-bottom:10px;">
                <form class="form-inline row" id="form_nhserver" action="/work-order/public/nhserver/store" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group col-sm-1"></div>
                    <div class="form-group col-sm-3">
                        <label>服务器</label>
                        <input class="form-control" type="text" name="host" placeholder="">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>端口</label>
                        <input class="form-control" style="width: 100px;" type="text" name="port" placeholder="">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>所在省</label>
                        <input class="form-control" type="text" name="province" placeholder="">
                    </div>
                    <div class="form-group col-sm-1">
                        <button type="button" class="btn btn-default" rel="nhserver">新建</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">存档工具</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline row" id="form_log" style="margin-bottom: 10px;" action="/work-order/public/log/download" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group col-sm-4">
                    <label>此日期之前的日志</label>
                    <input class="form-control" type="text" name="date" id="date" data-date-format="yyyy-mm-dd" placeholder="">
                </div>
                <div class="form-group col-sm-1">
                    <button type="button" class="btn btn-success" rel="download">下载</button>
                </div>
                <div class="form-group col-sm-1">
                    <button type="button" class="btn btn-danger" rel="deletelog">删除</button>
                </div>
            </form>
        </div>
    </div>
    <div style="height: 250px;"></div>
    <script type="text/javascript">
        $(document).ready(function(){

            $("button[rel='usn']").click(function(){
                $('#form_usn').ajaxSubmit(function(data){
                    $.scojs_message("修改成功", $.scojs_message.TYPE_OK);
                });
            });

            $("button[rel='usend']").click(function(){
                $('#form_usend').ajaxSubmit(function(data){
                    $.scojs_message("修改成功", $.scojs_message.TYPE_OK);
                });
            });

            $("button[rel='ucrm']").click(function(){
                $('#form_ucrm').ajaxSubmit(function(data){
                    $.scojs_message("修改成功", $.scojs_message.TYPE_OK);
                });
            });

            $("button[rel='utime']").click(function(){
                $('#form_utime').ajaxSubmit(function(data){
                    $.scojs_message("修改成功", $.scojs_message.TYPE_OK);
                });
            });
            $("button[rel='nhserver']").click(function(){
                $('#form_nhserver').ajaxSubmit(function(data){
                    var msg = '';
                    if(data.host){
                        msg = data.host;
                    }else if(data.port){
                        msg = data.port;
                    }else if(data.province){
                        msg = data.province;
                    }
                    if(msg!=''){
                        $.scojs_message(msg, $.scojs_message.TYPE_ERROR);
                        return;
                    }
                    $.scojs_message("新建成功", $.scojs_message.TYPE_OK);
                    location.reload();
                });
            });

            $("button[rel='unserver']").click(function(){
                var host = $(this).parents("form").find("#host").val();
                var port = $(this).parents("form").find("#port").val();
                var province = $(this).parents("form").find("#province").val();
                var id = $(this).parents("form").find("#id").val();
                $.ajax({
                    type: 'POST',
                    url: '/work-order/public/nhserver/update' ,
                    data: {id:id,host:host,port:port,province:province,_token:Config.token} ,
                    dataType: 'json',
                    success: function(data){
                        var msg = '';
                        if(data.host){
                            msg = data.host;
                        }else if(data.port){
                            msg = data.port;
                        }else if(data.province){
                            msg = data.province;
                        }
                        if(msg!=''){
                            $.scojs_message(msg, $.scojs_message.TYPE_ERROR);
                            return;
                        }
                        $.scojs_message("修改成功", $.scojs_message.TYPE_OK);
                    }
                });
            });

            $("button[rel='download']").click(function(){
                if($("#date").val()==""){
                    $.scojs_message("请选择日期", $.scojs_message.TYPE_ERROR);
                    return;
                }
                $("#form_log").attr("action","/work-order/public/log/download");
                //$("#form_log").attr("method","get");
                $('#form_log').submit();
            });

            $("button[rel='deletelog']").click(function(){
                if($("#date").val()==""){
                    $.scojs_message("请选择日期", $.scojs_message.TYPE_ERROR);
                    return;
                }
                if(confirm("您确定要删除此日期前的日志？")){
                    $("#form_log").attr("action","/work-order/public/log/deletelog");
                    $('#form_log').ajaxSubmit(function(data){
                        //$.scojs_message("修改成功", $.scojs_message.TYPE_OK);
                        $.scojs_message("删除成功", $.scojs_message.TYPE_OK);
                    });
                }
            });
        });
    </script>
@stop