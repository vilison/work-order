@extends('layouts.default')
@section('title')
    工单浏览
@stop
@section('styles')
    <link href="{{ asset('assets/bootstrap-sco/css/scojs.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/sco.message.css')}}" rel="stylesheet" media="screen">
   <style>
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
    <script type="text/javascript" src="{{ asset('assets/bootstrap-sco/js/sco.message.js')}}" charset="UTF-8"></script>
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            当前显示：{{$tickets->firstItem()}} - {{$tickets->lastItem()}} （共{{$tickets->total()}}），<span id="selNum">{{$num}}</span>选中
            <div class="pull-right"><a class="btn btn-primary" role="button" rel="export">导出</a></div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th rowspan="2">
                <input type="checkbox" id="all-check" {{$allCheck?'checked':''}}>
            </th>
            <th rowspan="2"><a href="index?name=RepairformSts&sort={{$name=='RepairformSts'&&$sort=='asc'?'desc':'asc'}}">工单状态<span class="glyphicon glyphicon-arrow-{{$name=='RepairformSts'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th colspan="3" style="text-align: center; border:none;">
                超时
            </th>
            <th rowspan="2"><a href="index?name=RepairCreateTime&sort={{$name=='RepairCreateTime'&&$sort=='asc'?'desc':'asc'}}">时间<span class="glyphicon glyphicon-arrow-{{$name=='RepairCreateTime'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="index?name=WFormId&sort={{$name=='WFormId'&&$sort=='asc'?'desc':'asc'}}">工单号<span class="glyphicon glyphicon-arrow-{{$name=='WFormId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="index?name=ModelId&sort={{$name=='ModelId'&&$sort=='asc'?'desc':'asc'}}">型号<span class="glyphicon glyphicon-arrow-{{$name=='ModelId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="index?name=status&sort={{$name==''&&$sort=='asc'?'desc':'asc'}}">省市<span class="glyphicon glyphicon-arrow-{{$name==''&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <!--<th rowspan="2"><a href="index?name=InstallAddress&sort={{$name=='InstallAddress'&&$sort=='asc'?'desc':'asc'}}">安装地址<span class="glyphicon glyphicon-arrow-{{$name=='InstallAddress'&&$sort=='desc'?'down':'up'}}"></span></a></th>-->
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
                    <td>{{$o->Engineer}}</td>
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
    {!! $tickets->appends(['name'=>$name,'sort'=>$sort])->render() !!}
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("a[rel='export']").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'checkExport' ,
                    data: {tag:'index',_token:Config.token} ,
                    dataType: 'json',
                    success: function(data){
                        if(!data.result){
                            $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                            return;
                        }
                        location.href = 'export?tag=index'
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

            setInterval(function(){
                location.reload();
            },60000*{{$setting->refresh_interval}});
        });
        function check(){
            var tids = new Array();
            $("input[name='tid']:checked").each(function(){
                tids.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: 'check' ,
                data: {tids:tids,tag:'index',_token:Config.token} ,
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
                data: {tids:tids,tag:'index',_token:Config.token} ,
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
                data: {tag:'index',_token:Config.token} ,
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