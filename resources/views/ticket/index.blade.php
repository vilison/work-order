@extends('layouts.default')
@section('styles')
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
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            当前显示：{{$tickets->firstItem()}} - {{$tickets->lastItem()}} （共{{$tickets->total()}}），<span id="selNum">{{$num}}</span>选中
            <div class="pull-right"><a class="btn btn-primary" href="#" role="button">导出</a></div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th rowspan="2">
                <input type="checkbox" id="all-check" {{$allCheck?'checked':''}}>
            </th>
            <th rowspan="2"><a href="order/index/?name=status&sort={{$name==''&&$sort=='asc'?'desc':'asc'}}">工单状态<span class="glyphicon glyphicon-arrow-{{$name==''&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th colspan="3" style="text-align: center; border:none;">
                超时
            </th>
            <th rowspan="2"><a href="order/index/?name=RepairCreateTime&sort={{$name=='RepairCreateTime'&&$sort=='asc'?'desc':'asc'}}">时间<span class="glyphicon glyphicon-arrow-{{$name=='RepairCreateTime'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="order/index/?name=WFormId&sort={{$name=='WFormId'&&$sort=='asc'?'desc':'asc'}}">工单号<span class="glyphicon glyphicon-arrow-{{$name=='WFormId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="order/index/?name=ModelId&sort={{$name=='ModelId'&&$sort=='asc'?'desc':'asc'}}">型号<span class="glyphicon glyphicon-arrow-{{$name=='ModelId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="order/index/?name=status&sort={{$name==''&&$sort=='asc'?'desc':'asc'}}">省市<span class="glyphicon glyphicon-arrow-{{$name==''&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th rowspan="2"><a href="order/index/?name=InstallAddress&sort={{$name=='InstallAddress'&&$sort=='asc'?'desc':'asc'}}">安装地址<span class="glyphicon glyphicon-arrow-{{$name=='InstallAddress'&&$sort=='desc'?'down':'up'}}"></span></a></th>
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
                    <td>{{$o->InstallAddress}}</td>
                    <td>
                        <a href="ticket/show/{{$o->id}}" class="btn btn-default btn-xs">查看</a>
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
            $("#all-check").change(function() {
                var isChecked = $(this).prop("checked");
                $("input[name='tid']").prop("checked", isChecked);
                if (isChecked) {
                    check();
                }else{
                    $("input[name='tid']").each(function(){
                        delCheck($(this).val());
                    });
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
                    delCheck($(this).val());
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
                url: 'ticket/check' ,
                data: {tids:tids,tag:'index',_token:Config.token} ,
                dataType: 'json',
                success: function(data){
                    changeCount(data.count);
                }
            });
        }

        function delCheck(tid){
            $.ajax({
                type: 'POST',
                url: 'ticket/delCheck' ,
                data: {tid:tid,tag:'index',_token:Config.token} ,
                dataType: 'json',
                success: function(data){
                    changeCount(data.count);
                }
            });
        }
        function clearCheck() {
            $.ajax({
                type: 'POST',
                url: 'ticket/clearCheck' ,
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