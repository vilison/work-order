<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ebs 调试</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-3.3.5/css/bootstrap.css')}}">
    <script src="{{ asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.form.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bootstrap-3.3.5/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script>
        Config = {
            'token': '{{csrf_token()}}'
        };
    </script>
    <link href="{{ asset('assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/scojs.css')}}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/bootstrap-sco/css/sco.message.css')}}" rel="stylesheet" media="screen">
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-sco/js/sco.message.js')}}" charset="UTF-8"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#btn").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'ebspost' ,
                    data: {xml:$("#xml").val(),_token:Config.token} ,
                    success: function(data){
                        $("#resp").text(data);
                    }
                });
            });

            $("#btn2").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'ebscallback' ,
                    data: {} ,
                    success: function(data){
                    }
                });
            });

            setInterval(function(){
                $.ajax({
                    type: 'POST',
                    url: 'ebslog' ,
                    data: {_token:Config.token} ,
                    success: function(data){
                        $("#log").text(data);
                    }
                });
            },10000);
        });
    </script>
</head>

<body>
<form id="call-form" action="ebscallback" method="post">
    <button id="btn2" type="button">Test callback</button>
</form>
<form id="post-form" action="ebspost" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    callback：https://123.57.218.251:443/work-order/public/ticket/ebscallback<br/>
    <textarea id="xml" name="xml" cols="100" rows="20">
        {{$xml}}
    </textarea>
    <a id="btn" class="btn btn-default">post</a>
</form>
    <pre id="resp">

    </pre>
    <pre id="log">

    </pre>

</body>
</html>
