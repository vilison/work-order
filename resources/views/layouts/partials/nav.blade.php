<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed navbar-left" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="nav nav-pills navbar-right">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        当前用户： {{Auth::user()->name}} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/work-order/public/user/info"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 个人设置</a></li>
                        <li><a href="/work-order/public/auth/logout"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> 登出</a></li>
                    </ul>
                </li>
            </ul>
            <!--<p class="navbar-text navbar-right">当前用户： <a href="/work-order/public/user/info" class="navbar-link">{{Auth::user()->name}}</a></p>-->
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{(Request::is('ticket/index*') ? 'active':'')}}"><a href="/work-order/public/ticket/index">工单浏览</a></li>
                <li class="{{(Request::is('ticket/search*') ? 'active':'')}}"><a href="/work-order/public/ticket/search">工单查询</a></li>
                <li class="{{(Request::is('user/index*') ? 'active':'')}}"><a href="/work-order/public/user/index">用户管理</a></li>
                <li class="{{(Request::is('setting/index*') ? 'active':'')}}"><a href="/work-order/public/setting/index">系统配置</a></li>
                <li class="{{(Request::is('log/index*') ? 'active':'')}}"><a href="/work-order/public/log/index">日志查看</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->
</nav>