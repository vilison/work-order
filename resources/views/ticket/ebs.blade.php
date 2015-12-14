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
                    url: 'ticket/ebspost' ,
                    data: {xml:$("#xml").val(),_token:Config.token} ,
                    success: function(data){
                        $("#resp").text(data);
                    }
                });
            });

            $("#btn2").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'ticket/ebscallback' ,
                    data: {} ,
                    success: function(data){
                    }
                });
            });

            setInterval(function(){
                $.ajax({
                    type: 'POST',
                    url: 'ticket/ebslog' ,
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
<form id="call-form" action="ticket/ebscallback" method="post">
    <button id="btn2" type="button">Test callback</button>
</form>
<form id="post-form" action="ticket/ebspost" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    callback：https://123.57.218.251:443/work-order/public/ticket/ebscallback<br/>
    <textarea id="xml" name="xml" cols="100" rows="20">
        <?xml version = '1.0' encoding = 'UTF-8'?>
        <WnspServiceRequest>
            <address/>
            <helpdeskNumber>10122015BIN0001</helpdeskNumber>
            <reportedDate/>
            <event>CREATE</event>
            <customerName>ABC Nanjin 南京农行</customerName>
            <customerAccountNumber>50CN5501585</customerAccountNumber>
            <customerHelpdeskNumber/>
            <customerTimezone>CSTCN</customerTimezone>
            <project/>
            <projectNumber/>
            <productSerialNumber>P03CNEQ_10015305</productSerialNumber>
            <productTag>1306011J</productTag>
            <productSystem/>
            <productDescription>ProCash 3100</productDescription>
            <productCustomerSerialnumber/>
            <installedAddress1></installedAddress1>
            <installedAddress2/>
            <installedAddress3></installedAddress3>
            <installedAddress4/>
            <installedCity>Chongqing</installedCity>
            <installedState/>
            <installedPostalcode>999999</installedPostalcode>
            <installedCountry>CN</installedCountry>
            <installedContact/>
            <installedPhone/>
            <installedFax/>
            <installedEmail/>
            <callerFirstName>Thomas</callerFirstName>
            <callerLastName>Schlößer</callerLastName>
            <callerPhone>+49 5251 693 4772</callerPhone>
            <callerPhoneType>PHONE</callerPhoneType>
            <callerEmail>thomas.schloesser@wincor-nixdorf.com</callerEmail>
            <callerPreferredLanguage/>
            <callerPreferredComm/>
            <errorType>TT</errorType>
            <urgency>PF</urgency>
            <summary>CN - CustIn - Agriculture Bank of China</summary>
            <customerErrorCode/>
            <problemCode/>
            <ordertext1>ordertext1</ordertext1>
            <ordertext2>ordertext2</ordertext2>
            <customerKey>CN_ABC_XINMAI</customerKey>
            <status>New</status>
            <channel>HTTP</channel>
            <replyAddress>https://123.57.218.251/work-order/public/ticket/ebscallback</replyAddress>
            <ownerName>CN Customer Interfaces</ownerName>
            <serviceRequestNumber/>
            <transactionNumber/>
            <targetDate/>
            <plannedEndCallback/>
            <plannedStartFieldService/>
            <plannedEndFieldService/>
            <sparepartProposal/>
            <preferredEngineer/>
            <ServiceProviderID/>
            <noteType />
            <noteContent />
        </WnspServiceRequest>
    </textarea>
    <a id="btn" class="btn btn-default">post</a>
</form>
    <pre id="resp">

    </pre>
    <pre id="log">

    </pre>

</body>
</html>
