<!DOCTYPE html>
<html lang="zh">
<head>
    <script type="text/javascript">
        var _speedMark = new Date();
    </script>
    <meta charset="UTF-8">
    <title>
        @section('title')
        @show
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="keywords" content="" />
    <meta name="author" content="vilison." />
    <meta name="description" content="@section('description') @show" />
    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="stylesheet" href="/assets/bootstrap-3.3.5/css/bootstrap.css">
    <script src="/assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/js/jquery.form.js" type="text/javascript"></script>
    <script src="/assets/bootstrap-3.3.5/js/bootstrap.min.js" type="text/javascript"></script>
    <script>
        Config = {
            'token': '{{csrf_token()}}'
        };
    </script>
    @yield('styles')
    @yield('scripts')
</head>
<body id="body">
<div id="wrap">
    <div class="container">
        @include('layouts.partials.nav')
        @yield('content')
    </div>
</div>
</body>
</html>