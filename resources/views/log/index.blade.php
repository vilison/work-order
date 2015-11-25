@extends('layouts.default')
@section('content')
    <form class="form-inline">
        <div class="form-group">
                <label for="operator" class="col-sm-4 control-label">人员</label>
                <select id="operator" class="col-sm-2 form-control" name="operator">
                    <option value="" {{$operator==''?'selected':''}}>全部</option>
                    @if(count($users))
                        @foreach($users as $u)
                            <option value="{{$u->name}}" {{$operator==$u->name?'selected':''}}>{{$u->name}}</option>
                        @endforeach
                    @endif
                </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail2">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
        </div>
        <button type="submit" class="btn btn-default">Send invitation</button>
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