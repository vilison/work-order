@extends('layouts.default')
@section('styles')
    <link href="/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
@stop
@section('scripts')
    <script type="text/javascript" src="/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/assets/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
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
    <form class="form-inline">
        <div class="form-group">
                <label for="operator">人员</label>
                <select id="operator" class="form-control" name="operator">
                    <option value="" {{$operator==''?'selected':''}}>全部</option>
                    @if(count($users))
                        @foreach($users as $u)
                            <option value="{{$u->name}}" {{$operator==$u->name?'selected':''}}>{{$u->name}}</option>
                        @endforeach
                    @endif
                </select>
        </div>
        <div class="form-group">
            <label for="bdate">时间 从</label>
            <input class="form-control" type="text" value="{{$bdate}}" name="bdate" id="bdate" data-date-format="yyyy-mm-dd" placeholder="">
        </div>
        <div class="form-group">
            <label for="bdate"> 到</label>
            <input class="form-control" type="text" value="{{$edate}}" name="edate" id="edate" data-date-format="yyyy-mm-dd" placeholder="">
        </div>
        <div class="form-group">
            <input class="form-control" type="text" value="{{$key}}" name="key" id="key" placeholder="查询关键字">
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>日期</th>
            <th>操作人</th>
            <th>动作</th>
        </tr>
        </thead>
        <tbody>
        @if(count($logs))
            @foreach($logs as $l)
                <tr id="{{$l->id}}">
                    <td>{{$l->created_at}}</td>
                    <td>{{$l->operator}}</td>
                    <td>{{$l->action}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    {!! $logs->render() !!}
    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
@stop