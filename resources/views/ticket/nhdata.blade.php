@extends('layouts.default')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">农行接口数据原文</h3>
        </div>
        <div class="panel-body">
            <pre>
                {{$ticket->data_content}}
            </pre>
        </div>
    </div>
@stop