@extends('layouts.default')
@section('title')
    工单查询
@stop
@section('styles')
    <link href="{{ asset('assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/scojs.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/sco.message.css')}}" rel="stylesheet" media="screen">
    <style>
        @media (max-width: 640px) {
            .export{
                display: none;
            }
        }
        .table > thead > tr > th {
            vertical-align: middle;
            text-align: center;
        }
        .table > tbody > tr > td{
            text-align: center;
        }
    </style>
@stop
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-sco/js/sco.message.js')}}" charset="UTF-8"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#bdate').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
            $('#edate').datetimepicker({
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
        <div class="panel-body">
            <div>
            搜索结果：{{$tickets->firstItem()}} - {{$tickets->lastItem()}} （共{{$tickets->total()}}），<span id="selNum">{{$num}}</span>选中
            <div class="pull-right">
                <a class="btn btn-primary export" style="margin-right: 10px;" role="button" rel="export">导出</a>
                <a class="btn btn-default" role="button" rel="col"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></a></div>
                <div style="clear: both;"></div>
            </div>
            <div id="col-area" style="display:none;margin-top: 10px;">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="bdate">时间</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="bdate" name="bdate" data-date-format="yyyy-mm-dd" placeholder="开始时间" value="{{$bdate}}">
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="edate" name="edate" data-date-format="yyyy-mm-dd" placeholder="结束时间" value="{{$edate}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="province">省市</label>
                        <div class="col-sm-2">
                            <select id="province" name="province" class="form-control">
                                <option value="0">不限</option>
                                @if(count($nhservers))
                                    @foreach($nhservers as $nhserver)
                                        <option value="{{$nhserver->id}}" {{$nhserver->id==$province?'selected':''}}>{{$nhserver->province}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sn">序列号</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="sn" name="sn" placeholder="" value="{{$sn}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="ccc">CCC工单号</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="ccc" name="ccc" placeholder="" value="{{$ccc}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="wformid">农行工单号</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="wformid" name="wformid" placeholder="" value="{{$wformid}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="engineer">工程师</label>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" id="engineer" name="engineer" placeholder="" value="{{$engineer}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="ticketStatu">工单状态</label>
                        <div class="col-sm-2">
                            <select id="ticketStatu" name="ticketStatu" class="form-control">
                                <option value="0" {{$ticketStatu==0?'selected':''}}>不限</option>
                                <option value="1" {{$ticketStatu==1?'selected':''}}>保修</option>
                                <option value="2" {{$ticketStatu==2?'selected':''}}>已反馈</option>
                                <option value="3" {{$ticketStatu==3?'selected':''}}>到场</option>
                                <option value="4" {{$ticketStatu==4?'selected':''}}>关闭</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="timeoutMode">超时状态</label>
                        <div class="col-sm-2">
                            <select id="timeoutMode" name="timeoutMode" class="form-control">
                                <option value="0" {{$timeoutMode==0?'selected':''}}>不限</option>
                                <option value="1" {{$timeoutMode==1?'selected':''}}>响应</option>
                                <option value="2" {{$timeoutMode==2?'selected':''}}>到场</option>
                                <option value="3" {{$timeoutMode==3?'selected':''}}>修复</option>
                            </select>
                        </div>
                        <div class="col-sm-8" style="text-align: right;">
                            <button type="submit" class="btn btn-default">查询</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th rowspan="2">
                <input type="checkbox" id="all-check" {{$allCheck?'checked':''}}>
            </th>
            <th rowspan="2"><a href="search?name=RepairformSts&sort={{$name=='RepairformSts'&&$sort=='asc'?'desc':'asc'}}">工单状态<span class="glyphicon glyphicon-arrow-{{$name=='RepairformSts'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th colspan="3" style="text-align: center; border:none;">
                超时
            </th>
            <th rowspan="2"><a href="search?name=RepairCreateTime&sort={{$name=='RepairCreateTime'&&$sort=='asc'?'desc':'asc'}}">时间<span class="glyphicon glyphicon-arrow-{{$name=='RepairCreateTime'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="search?name=WFormId&sort={{$name=='WFormId'&&$sort=='asc'?'desc':'asc'}}">工单号<span class="glyphicon glyphicon-arrow-{{$name=='WFormId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="search?name=ModelId&sort={{$name=='ModelId'&&$sort=='asc'?'desc':'asc'}}">型号<span class="glyphicon glyphicon-arrow-{{$name=='ModelId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="search?name=status&sort={{$name==''&&$sort=='asc'?'desc':'asc'}}">省市<span class="glyphicon glyphicon-arrow-{{$name==''&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <!--<th rowspan="2"><a href="search?name=InstallAddress&sort={{$name=='InstallAddress'&&$sort=='asc'?'desc':'asc'}}">安装地址<span class="glyphicon glyphicon-arrow-{{$name=='InstallAddress'&&$sort=='desc'?'down':'up'}}"></span></a></th>-->
            <th rowspan="2"><a href="index?name=Engineer&sort={{$name=='Engineer'&&$sort=='asc'?'desc':'asc'}}">工程师<span class="glyphicon glyphicon-arrow-{{$name=='Engineer'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2">操作</th>
        </tr>
        <tr >
            <th style="border-top: none;">响应</th>
            <th style="border-top: none;">到场</th>
            <th style="border-top: none;">修复</th>
        </tr>
        </thead>
        <tbody>
        @if(count($tickets))
            @foreach($tickets as $o)
                <tr id="{{$o->id}}">
                    <td scope="row">
                        <input name="tid" type="checkbox" value="{{$o->id}}" {{$o->getCheck($tids)?'checked':''}}/>
                    </td>
                    <td>{{$o->getTicketStatu()}}</td>
                    <td>{{$o->getResp($setting->warn_timeout)}}</td>
                    <td>{{$o->getArrival($setting->warn_timeout)}}</td>
                    <td>{{$o->getRepair($setting->warn_timeout)}}</td>
                    <td>{{$o->RepairCreateTime}}</td>
                    <td>{{$o->WFormId}}</td>
                    <td>{{$o->BrandId}}-{{$o->ModelId}}</td>
                    <td>{{$o->getLocation()}}</td>
                    <!--<td>{{$o->InstallAddress}}</td>-->
                    <td>{{$o->getEngineer()}}</td>
                    <td>
                        <a href="show/{{$o->id}}" class="btn btn-default btn-xs">查看</a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <button type="button" class="btn btn-default" id="clearCheck">清除所有选定</button>
    <div class="pull-right">
        {!! $tickets->appends(['name'=>$name,'sort'=>$sort,'bdate'=>$bdate,'edate'=>$edate,'province'=>$province,'sn'=>$sn,'ccc'=>$ccc,'wformid'=>$wformid,'engineer'=>$engineer,'ticketStatu'=>$ticketStatu,'timeoutMode'=>$timeoutMode])->render() !!}
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("a[rel='col']").click(function(){
                if($("#col-area").css("display") == "none"){
                    var down = $(".glyphicon-menu-down");
                    down.removeClass("glyphicon-menu-down");
                    down.addClass("glyphicon-menu-up");
                    $("#col-area").css("display","block");
                }else{
                    var up = $(".glyphicon-menu-up");
                    up.removeClass("glyphicon-menu-up");
                    up.addClass("glyphicon-menu-down");
                    $("#col-area").css("display","none");
                }
            });
            $("a[rel='export']").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'checkExport' ,
                    data: {tag:'search',_token:Config.token} ,
                    dataType: 'json',
                    success: function(data){
                        if(!data.result){
                            $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                            return;
                        }
                        location.href = 'export?tag=search'
                    }
                });
            });
            $("#all-check").change(function() {
                var isChecked = $(this).prop("checked");
                $("input[name='tid']").prop("checked", isChecked);
                if (isChecked) {
                    check();
                }else{
                    var tids = new Array();
                    $("input[name='tid']").each(function(){
                        tids.push($(this).val());
                    });
                    delCheck(tids);
                }
            });
            $("#clearCheck").click(function(){
                clearCheck();
            });
            $("input[name='tid']").change(function(){
                var isChecked = $(this).prop("checked");
                if(isChecked){
                    check();
                }else{
                    delCheck([$(this).val()]);
                    $("#all-check").prop("checked", false);
                }
            });
        });
        function check(){
            var tids = new Array();
            $("input[name='tid']:checked").each(function(){
                tids.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: 'check' ,
                data: {tids:tids,tag:'search',_token:Config.token} ,
                dataType: 'json',
                success: function(data){
                    changeCount(data.count);
                }
            });
        }

        function delCheck(tids){
            $.ajax({
                type: 'POST',
                url: 'delCheck' ,
                data: {tids:tids,tag:'search',_token:Config.token} ,
                dataType: 'json',
                success: function(data){
                    changeCount(data.count);
                }
            });
        }
        function clearCheck() {
            $.ajax({
                type: 'POST',
                url: 'clearCheck' ,
                data: {tag:'search',_token:Config.token} ,
                dataType: 'json',
                success: function(data){
                    if(data.result){
                        $("input:checkbox").prop("checked", false);
                        changeCount(0);
                    }
                }
            });
        }

        function changeCount(num){
            $("#selNum").text(num);
        }
    </script>
@stop