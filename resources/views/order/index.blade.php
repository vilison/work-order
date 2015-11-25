@extends('layouts.default')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            当前显示：{{$orders->firstItem()}} - {{$orders->lastItem()}} （共{{$orders->total()}}），0选中
            <div class="pull-right"><a class="btn btn-primary" href="#" role="button">导出</a></div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                <input type="checkbox">
            </th>
            <th><a href="/order/index/?name=status&sort={{$name==''&&$sort=='asc'?'desc':'asc'}}">当前状态<span class="glyphicon glyphicon-arrow-{{$name==''&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th><a href="/order/index/?name=RepairCreateTime&sort={{$name=='RepairCreateTime'&&$sort=='asc'?'desc':'asc'}}">时间<span class="glyphicon glyphicon-arrow-{{$name=='RepairCreateTime'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th><a href="/order/index/?name=WFormId&sort={{$name=='WFormId'&&$sort=='asc'?'desc':'asc'}}">工单号<span class="glyphicon glyphicon-arrow-{{$name=='WFormId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th><a href="/order/index/?name=ModelId&sort={{$name=='ModelId'&&$sort=='asc'?'desc':'asc'}}">型号<span class="glyphicon glyphicon-arrow-{{$name=='ModelId'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th><a href="/order/index/?name=status&sort={{$name==''&&$sort=='asc'?'desc':'asc'}}">省市<span class="glyphicon glyphicon-arrow-{{$name==''&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th><a href="/order/index/?name=InstallAddress&sort={{$name=='InstallAddress'&&$sort=='asc'?'desc':'asc'}}">安装地址<span class="glyphicon glyphicon-arrow-{{$name=='InstallAddress'&&$sort=='desc'?'down':'up'}}"></span></a></th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(count($orders))
            @foreach($orders as $o)
                <tr id="{{$o->WFormId}}">
                    <th scope="row">
                        <input type="checkbox">
                    </th>
                    <td></td>
                    <td>{{$o->RepairCreateTime}}</td>
                    <td>{{$o->WFormId}}</td>
                    <td>{{$o->ModelId}}</td>
                    <td></td>
                    <td>{{$o->InstallAddress}}</td>
                    <td>
                        <button rel="reset" type="button" class="btn btn-default btn-xs">查看</button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">清除所有选定</button>
    <div class="pull-right">
    {!! $orders->appends(['name'=>$name,'sort'=>$sort])->render() !!}
    </div>
    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
@stop