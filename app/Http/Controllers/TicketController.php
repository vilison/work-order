<?php

namespace App\Http\Controllers;
require __DIR__ . '/../../../vendor/autoload.php';

use App\Setting;
use App\Ticket;
use Curl\Curl;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $pageSize = 10;
        $name = $request->input('name', 'RepairCreateTime');
        $sort = $request->input('sort', 'desc');
        $tickets = Ticket::current()->order($name,$sort)->paginate($pageSize);
        $setting = Setting::find(1);
        $tids = $request->session()->get('index.tids',array());
        $num = count($tids);
        $selnum = 0;
        foreach($tickets as $ticket){
            if(in_array($ticket->id,$tids))
                $selnum++;
        }
        $allCheck = false;
        if($selnum==$pageSize)
            $allCheck = true;
        return view('ticket.index',array(
            'tickets'=>$tickets,
            'setting'=>$setting,
            'name'=>$name,
            'sort'=>$sort,
            'num' => $num,
            'tids'=>$tids,
            'allCheck'=>$allCheck
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $ticket = Ticket::find($id);
        $setting = Setting::find(1);
        return view('ticket.show',array(
            'ticket'=>$ticket,
            'setting'=>$setting
        ));
    }

    public function nhdata($id){
        $ticket = Ticket::find($id);
        return view('ticket.nhdata',array(
            'ticket'=>$ticket
        ));
    }

    public function ebsdata($id){
        $ticket = Ticket::find($id);
        return view('ticket.ebsdata',array(
            'ticket'=>$ticket
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function check(Request $request){
        $tids = $request->tids;
        $ids = $request->session()->get('index.tids',array());
        foreach($tids as $tid){
            $ids[$tid] = $tid;
        }
        $request->session()->put('index.tids',$ids);
        $data['count'] = count($ids);
        $data['tids'] = $ids;
        echo json_encode($data);
    }

    public function clearCheck(Request $request){
        $request->session()->forget('index.tids');
        echo json_encode(array('result'=>true));
    }

    public function delCheck(Request $request){
        $tid = $request->tid;
        $ids = $request->session()->get('index.tids',array());
        unset($ids[$tid]);
        $request->session()->put('index.tids',$ids);
        $data['count'] = count($ids);
        $data['tids'] = $ids;
        echo json_encode($data);
    }

    public function appGetMaintianWorkFormAct(){
        $curl = new Curl();
        $p = 0;
        $retCount = 1;
        while($retCount!=0){
            $curl->get('http://abc.yihuacomputer.com:8021/WebSite/appGetMaintianWorkFormAct.ebf', array(
                'MaintianComTel' => '400335',
                'PageIndex' => $p++
            ));
            $result = $curl->response;
            $result = mb_convert_encoding($result, "UTF-8", "gb2312");
            $json_result = json_decode($result);
            $retCount = count($json_result->Ret);
            foreach($json_result->Ret as $ret){
                $order = Ticket::find($ret->WFormId);
                if(empty($ticket)){
                    $ticket = new Ticket;
                    $ticket->WFormId = $ret->WFormId;
                    $ticket->Identifier = $ret->Identifier;
                    $ticket->WFormSetTime = $ret->WFormSetTime;
                    $ticket->ReplyDue = $ret->ReplyDue;
                    $ticket->IsChecked = $ret->IsChecked;
                    $ticket->ArriveDue = $ret->ArriveDue;
                    $ticket->WFormContent = $ret->WFormContent;
                    $ticket->OrgName = $ret->OrgName;
                    $ticket->InstallAddress = $ret->InstallAddress;
                    $ticket->ModelId = $ret->ModelId;
                    $ticket->BrandId = $ret->BrandId;
                    $ticket->DevManager = $ret->DevManager;
                    $ticket->DevManagerTel = $ret->DevManagerTel;
                    $ticket->RepairInfo = json_encode($ret->RepairInfo);
                    $ticket->Engineer = $ret->RepairInfo->Engineer;
                    $ticket->RepairCreateTime = $ret->RepairInfo->RepairCreateTime;
                    $ticket->RespTime = $ret->RepairInfo->RespTime;
                    $ticket->ArrivalTime = $ret->RepairInfo->ArrivalTime;
                    $ticket->RepairformSts = $ret->RepairInfo->RepairformSts;
                    $ticket->MaintianComTel = $ret->RepairInfo->MaintianComTel;
                    $ticket->GivenArrivalTime = $ret->RepairInfo->GivenArrivalTime;
                    $ticket->Mobile = $ret->RepairInfo->Mobile;
                    $ticket->save();
                }
            }
        }
        $curl->close();
    }

    public function ebs(){
        return view('ticket.ebs');
    }

    public function ebspost(Request $request){
        $callback = "http://123.57.218.251:8000/ticket/ebscallback";
        $xml = $request->xml;
        /**
        $xml = "<?xml version = '1.0' encoding = 'UTF-8'?>
                <WnspServiceRequest>
                    <address/>
                    <helpdeskNumber>03122015TSC0001</helpdeskNumber>
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
                    <replyAddress>$callback</replyAddress>
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
                </WnspServiceRequest>";
         * */
        $file = "log.txt";
        $dt = date('Y-m-d H:i:s');
        file_put_contents($file, "post $dt\r\n", FILE_APPEND | LOCK_EX);
        file_put_contents($file, "$xml\r\n\r\n\r\n\r\n", FILE_APPEND | LOCK_EX);
        $curl = new Curl();
        $curl->setHeader('Content-Type', 'text/xml');
        $curl->post('https://edi-test.wincor-nixdorf.com/customer-in/v3.0/incident', $xml);
        echo $curl->response;
    }

    public function ebscallback(){
        $file_in = file_get_contents("php://input"); //接收post数据
        $xml = simplexml_load_string($file_in);//转换post数据为simplexml对象
        $file = "log.txt";
        $dt = date('Y-m-d H:i:s');
        file_put_contents($file, "callback $dt", FILE_APPEND | LOCK_EX);
        foreach($xml->children() as $child)    //遍历所有节点数据
        {
            $result = $child->getName() . ": " . $child . "\r\n"; //打印节点名称和节点值
            file_put_contents($file, $result, FILE_APPEND | LOCK_EX);
        }
        file_put_contents($file, "\r\n\r\n\r\n", FILE_APPEND | LOCK_EX);
    }

    public function ebslog(){
        $file = fopen("log.txt", "r") or die("Unable to open file!");
        echo fread($file,filesize("log.txt"));
        fclose($file);
    }
}
