@extends('layouts.default')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">基本信息</h3>
        </div>
        <div class="panel-body">
            <p>
                工单编号：{{$ticket->WFormId}}<br/>
                CCC编号：<br/>
                工单状态：{{$ticket->getTicketStatu()}}<br/>
                超时：{{$ticket->getResp($setting->warn_timeout,"响应超时")}}{{$ticket->getArrival($setting->warn_timeout,"到场超时")}}{{$ticket->getRepair($setting->warn_timeout,"修复超时")}}<br/>
                所在地区：{{$ticket->getLocation()}}<br/>
                负责工程师：{{$ticket->created_at}}<br/>
                最后更新：{{$ticket->created_at}}
            </p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">工单详情</h3>
        </div>
        <div class="panel-body">
            <p>
                农行前置编号：{{$ticket->Identifier}}<br/>
                设备序列号：{{$ticket->Identifier}}<br/>
                工单开始时间：{{$ticket->WFormSetTime}}<br/>
                未响应时间：{{$ticket->ReplyDue}}<br/>
                是否响应：{{$ticket->IsChecked==0?'否':'是'}}<br/>
                到场超时时间：{{$ticket->ArriveDue}}<br/>
                机构名称：{{$ticket->OrgName}}<br/>
                安装地址：{{$ticket->InstallAddress}}<br/>
                品牌：{{$ticket->BrandId}}<br/>
                型号：{{$ticket->ModelId}}<br/>
                故障内容：
            </p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">维修状态</h3>
        </div>
        <div class="panel-body">
            <p>
                工程师：{{$ticket->Engineer}}<br/>
                报修时间：{{$ticket->RepairCreateTime}}<br/>
                响应时间：{{$ticket->RespTime}}<br/>
                到场认证时间：{{$ticket->ArrivalTime}}<br/>
                厂商维保电话：{{$ticket->MaintianComTel}}<br/>
                厂商预计到达时间：{{$ticket->GivenArrivalTime}}<br/>
                农行保修人电话：{{$ticket->Mobile}}
            </p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">报警状态</h3>
        </div>
        <div class="panel-body">
            <p>
                响应超时报警：{{$ticket->flag1==0?'未发送':'已发送'}}<br/>
                到场超时报警：{{$ticket->flag2==0?'未发送':'已发送'}}<br/>
                修复超时报警：{{$ticket->flag3==0?'未发送':'已发送'}}<br/>
            </p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">数据原文</h3>
        </div>
        <div class="panel-body">
            <p>
                <a href="/ticket/nhdata/{{$ticket->id}}" class="btn btn-default btn-xs">农行接口数据原文</a>
                <a href="#" class="btn btn-default btn-xs">EBS接口数据原文</a>
            </p>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
@stop