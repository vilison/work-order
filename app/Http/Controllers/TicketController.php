<?php

namespace App\Http\Controllers;
require __DIR__ . '/../../../vendor/autoload.php';

use App\Nhserver;
use App\Setting;
use App\Ticket;
use Curl\Curl;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $sort = $request->input('sort', 'asc');
        $tickets = Ticket::current()->order($name,$sort)->paginate($pageSize);
        $tickets->setPath('index');
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

    public function search(Request $request)
    {
        $pageSize = 10;
        $name = $request->input('name', 'RepairCreateTime');
        $sort = $request->input('sort', 'desc');
        $bdate = $request->input('bdate', '');
        $edate = $request->input('edate', '');
        $province = $request->input('province', '0');
        $sn = $request->input('sn', '');
        $ccc = $request->input('ccc', '');
        $wformid = $request->input('wformid', '');
        $engineer = $request->input('engineer', '');
        $ticketStatu = $request->input('ticketStatu', '0');
        $timeoutMode = $request->input('timeoutMode', '0');

        if($timeoutMode!=0){
            $ticketStatu = $timeoutMode;
        }

        $setting = Setting::find(1);

        $tickets = Ticket::current()->between($bdate,$edate)->province($province)->sn($sn)->ccc($ccc)->wformid($wformid)->engineer($engineer)->ticketStatu($ticketStatu)->timeoutMode($timeoutMode,$setting->warn_timeout)->order($name,$sort)->paginate($pageSize);
        $tickets->setPath('search');
        $setting = Setting::find(1);
        $tids = $request->session()->get('search.tids',array());
        $num = count($tids);
        $selnum = 0;
        foreach($tickets as $ticket){
            if(in_array($ticket->id,$tids))
                $selnum++;
        }
        $allCheck = false;
        if($selnum==$pageSize)
            $allCheck = true;
        $nhservers = Nhserver::all();
        return view('ticket.search',array(
            'tickets'=>$tickets,
            'setting'=>$setting,
            'name'=>$name,
            'sort'=>$sort,
            'num' => $num,
            'tids'=>$tids,
            'allCheck'=>$allCheck,
            'nhservers'=>$nhservers,
            'bdate'=>$bdate,
            'edate'=>$edate,
            'province'=>$province,
            'sn'=>$sn,
            'ccc'=>$ccc,
            'wformid'=>$wformid,
            'engineer'=>$engineer,
            'ticketStatu'=>$ticketStatu,
            'timeoutMode'=>$timeoutMode
        ));
    }

    public function checkExport(Request $request){
        $tag = $request->tag;
        $ids = $request->session()->get($tag.'.tids',array());
        if(count($ids) == 0){
            return json_encode(array('result'=>false,'msg'=>'请选择要导出的数据'));
        }
        return json_encode(array('result'=>true,'msg'=>''));
    }

    public function export(Request $request){
        $tag = $request->tag;
        $ids = $request->session()->get($tag.'.tids',array());
//        if(count($ids) == 0){
//            return json_encode(array('msg'=>'请选择要导出的数据'));
//        }
        $heads = ['地区','记录时间','工单编号','前置编号','工单开始时间','未响应时间','是否响应','到场超时时间','故障内容','机构名称','安装地址','型号','品牌','反馈工程师','报修时间','响应时间','到场认证时间','报修状态','厂商的维保电话','厂商给出的预计到达时间','农行报修人的电话','EBS返回的编码'];
        $cellData[] = $heads;
        foreach($ids as $id){
            $ticket = Ticket::find($id);
            $location = '';
            if($ticket->location_id != 0){
                $nhserver = Nhserver::find($ticket->location_id);
                if($nhserver)
                    $location = $nhserver->province;
            }
            $cell = [$location,$ticket->time_log,$ticket->WFormId,$ticket->Identifier,$ticket->WFormSetTime,$ticket->ReplyDue,$ticket->IsChecked,$ticket->ArriveDue,$ticket->WFormContent,$ticket->OrgName,$ticket->InstallAddress,$ticket->ModelId,$ticket->BrandId,$ticket->Engineer,$ticket->RepairCreateTime,$ticket->RespTime,$ticket->ArrivalTime,$ticket->RepairformSts,$ticket->MaintianComTel,$ticket->GivenArrivalTime,$ticket->Mobile,$ticket->ebs_id];
            $cellData[] = $cell;
        }
        Excel::create(time(),function($excel) use ($cellData){
            $excel->sheet('data', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
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
        $tag = $request->tag;
        $ids = $request->session()->get($tag.'.tids',array());
        foreach($tids as $tid){
            $ids[$tid] = $tid;
        }
        $request->session()->put($tag.'.tids',$ids);
        $data['count'] = count($ids);
        $data['tids'] = $ids;
        echo json_encode($data);
    }

    public function clearCheck(Request $request){
        $tag = $request->tag;
        $request->session()->forget($tag.'.tids');
        echo json_encode(array('result'=>true));
    }

    public function delCheck(Request $request){
        $tids = $request->tids;
        $tag = $request->tag;
        $ids = $request->session()->get($tag.'.tids',array());
        foreach($tids as $tid){
            unset($ids[$tid]);
        }
        $request->session()->put($tag.'.tids',$ids);
        $data['count'] = count($ids);
        $data['tids'] = $ids;
        echo json_encode($data);
    }

    public function appGetMaintianWorkFormAct(){
        $nhservers = Nhserver::all();
        $curl = new Curl();
        foreach($nhservers as $nhserver){
            $p = 0;
            $retCount = 1;
            while($retCount!=0){
                $curl->get('http://'.$nhserver->host.':'.$nhserver->port.'/WebSite/appGetMaintianWorkFormAct.ebf', array(
                    'MaintianComTel' => '400335',
                    'PageIndex' => $p++
                ));
                $result = $curl->response;
                $result = mb_convert_encoding($result, "UTF-8", "gb2312");
                $json_result = json_decode($result);
                $retCount = count($json_result->Ret);
                foreach($json_result->Ret as $ret){
                    $historyTicket = Ticket::current()->wformid($ret->WFormId)->find();
                    if(empty($historyTicket)){
                        //step 1 save record
                        $millisecond = microtime(true)*1000;
                        $time = explode(".",$millisecond);
                        $millisecond = $time[0];
                        $api_id = 'ABC'.$millisecond;
                        $ticket = new Ticket;
                        $ticket->current = 1;
                        $ticket->location_id = $nhserver->id;
                        $ticket->time_log = date('Y-m-d H:i:s');
                        $ticket->data_content = $result;
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
                        $ticket->RepairInfo = json_encode($ret->RepairInfo);
                        $ticket->Engineer = $ret->RepairInfo->Engineer;
                        $ticket->RepairCreateTime = $ret->RepairInfo->RepairCreateTime;
                        $ticket->RespTime = $ret->RepairInfo->RespTime;
                        $ticket->ArrivalTime = $ret->RepairInfo->ArrivalTime;
                        $ticket->RepairformSts = $ret->RepairInfo->RepairformSts;
                        $ticket->MaintianComTel = $ret->RepairInfo->MaintianComTel;
                        $ticket->GivenArrivalTime = $ret->RepairInfo->GivenArrivalTime;
                        $ticket->Mobile = $ret->RepairInfo->Mobile;
                        $ticket->api_id = $api_id;
                        $ticket->save();

                        //step 2 send email

                        //step 3 call ebs api
                    }else{
                        //check update
                        if($historyTicket->Identifier != $ret->Identifier ||
                            $historyTicket->WFormSetTime != $ret->WFormSetTime ||
                                $historyTicket->ReplyDue != $ret->ReplyDue ||
                                    $historyTicket->IsChecked != $ret->IsChecked ||
                                        $historyTicket->ArriveDue != $ret->ArriveDue ||
                                            $historyTicket->WFormContent != $ret->WFormContent ||
                                                $historyTicket->OrgName != $ret->OrgName ||
                                                    $historyTicket->InstallAddress != $ret->InstallAddress ||
                                                        $historyTicket->ModelId != $ret->ModelId ||
                                                            $historyTicket->BrandId != $ret->BrandId ||
                                                                $historyTicket->Engineer != $ret->RepairInfo->Engineer ||
                                                                    $historyTicket->RepairCreateTime != $ret->RepairInfo->RepairCreateTime ||
                                                                        $historyTicket->RespTime != $ret->RepairInfo->RespTime ||
                                                                            $historyTicket->ArrivalTime != $ret->RepairInfo->ArrivalTime ||
                                                                                $historyTicket->RepairformSts != $ret->RepairInfo->RepairformSts ||
                                                                                    $historyTicket->MaintianComTel != $ret->RepairInfo->MaintianComTel ||
                                                                                        $historyTicket->GivenArrivalTime != $ret->RepairInfo->GivenArrivalTime ||
                                                                                            $historyTicket->Mobile != $ret->RepairInfo->Mobile
                        ){
                            $ticket = new Ticket;
                            $ticket->current = 1;
                            $ticket->location_id = $historyTicket->location_id;
                            $ticket->time_log = date('Y-m-d H:i:s');
                            $ticket->data_content = $result;
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
                            $ticket->RepairInfo = json_encode($ret->RepairInfo);
                            $ticket->Engineer = $ret->RepairInfo->Engineer;
                            $ticket->RepairCreateTime = $ret->RepairInfo->RepairCreateTime;
                            $ticket->RespTime = $ret->RepairInfo->RespTime;
                            $ticket->ArrivalTime = $ret->RepairInfo->ArrivalTime;
                            $ticket->RepairformSts = $ret->RepairInfo->RepairformSts;
                            $ticket->MaintianComTel = $ret->RepairInfo->MaintianComTel;
                            $ticket->GivenArrivalTime = $ret->RepairInfo->GivenArrivalTime;
                            $ticket->Mobile = $ret->RepairInfo->Mobile;
                            $ticket->api_id = $historyTicket->api_id;
                            $ticket->ebs_id = $historyTicket->ebs_id;
                            $ticket->ebs_content = $historyTicket->ebs_content;
                            $ticket->flag1 = $historyTicket->flag1;
                            $ticket->flag2 = $historyTicket->flag2;
                            $ticket->flag3 = $historyTicket->flag3;
                            $ticket->flag4 = $historyTicket->flag4;
                            $ticket->flag5 = $historyTicket->flag5;
                            $ticket->save();

                            $historyTicket->current = 0;
                            $historyTicket->save();
                        }
                    }
                }
            }
            //Timeout not responding (Select * from tb_ticket where current=1 and repairformset=1 and flag1=0 and repaircreatetime is not null and datediff(mi,repaircreatetime,now)>20)
            $timeout_tickets = DB::select('select * from tickets where current=1 and RepairformSts=1 and flag1=0 and RepairCreateTime is not null and datediff(mi,RepairCreateTime,now)>20');
            foreach($timeout_tickets as $t){
                //send email to user

            }
            //update flag1 = 1;
            DB::update('update tickets set flag1 = 1 where current=1 and RepairformSts=1 and flag1=0 and RepairCreateTime is not null and datediff(mi,RepairCreateTime,now)>20');

            //Timeout is not present (Select * from tb_ticket where current=1 and repairformset=2 and flag2=0 and resptime is not null and datediff(mi,resptime,now)>20)
            $timeout_tickets = DB::select('select * from tickets where current=1 and RepairformSts=2 and flag2=0 and RespTime is not null and datediff(mi,RespTime,now)>20');
            foreach($timeout_tickets as $t){
                //send email to user

            }
            //update flag2 = 1;
            DB::update('update tickets set flag2 = 1 where current=1 and RepairformSts=2 and flag2=0 and RespTime is not null and datediff(mi,RespTime,now)>20');

            //Timeout not repaired (Select * from tb_ticket where current=1 and repairformset=3 and flag3=0 and arrivaltime is not null and datediff(mi,arrivaltime,now)>20)
            $timeout_tickets = DB::select('select * from tickets where current=1 and RepairformSts=3 and flag3=0 and ArrivalTime is not null and datediff(mi,ArrivalTime,now)>20');
            foreach($timeout_tickets as $t){
                //send email to user

            }
            //update flag3 = 1;
            DB::update('update tickets set flag3 = 1 where current=1 and RepairformSts=3 and flag3=0 and ArrivalTime is not null and datediff(mi,ArrivalTime,now)>20');
        }
        $curl->close();
    }

    public function ebs(){
        //10122015BIN0001
        $millisecond = microtime(true)*1000;
        $time = explode(".",$millisecond);
        $millisecond = $time[0];
        $xml = "<?xml version = '1.0' encoding = 'UTF-8'?>
        <WnspServiceRequest>
            <address/>
            <helpdeskNumber>ABC".$millisecond."</helpdeskNumber>
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
        </WnspServiceRequest>";
        return view('ticket.ebs',array(
            'xml'=>$xml
        ));
    }

    public function ebspost(Request $request){
        //$callback = "http://123.57.218.251:8000/ticket/ebscallback";
        $xml = $request->xml;
        $file = "log.txt";
        $dt = date('Y-m-d H:i:s');
        file_put_contents($file, "post $dt\r\n", FILE_APPEND | LOCK_EX);
        file_put_contents($file, "$xml\r\n\r\n\r\n\r\n", FILE_APPEND | LOCK_EX);
        $curl = new Curl();
        $curl->setHeader('Content-Type', 'text/xml;charset=UTF-8');

        $curl->post('https://edi-test.wincor-nixdorf.com/customer-in/v3.0/incident', utf8_encode($xml));
        //$curl->post('http://42.121.124.76/youhui/ebs_test.asp', $xml);
        echo $curl->response;
    }

    public function ebscallback(Request $request){
        $input = $request->all();
        $file = "log.txt";
        $dt = date('Y-m-d H:i:s');
        file_put_contents($file, "callback $dt", FILE_APPEND | LOCK_EX);
        file_put_contents($file, $input, FILE_APPEND | LOCK_EX);
//
//        $file_in = file_get_contents("php://input"); //接收post数据
//        $xml = simplexml_load_string($file_in);//转换post数据为simplexml对象
//        $file = "log.txt";
//        $dt = date('Y-m-d H:i:s');
//        file_put_contents($file, "callback $dt", FILE_APPEND | LOCK_EX);
//        foreach($xml->children() as $child)    //遍历所有节点数据
//        {
//            $result = $child->getName() . ": " . $child . "\r\n"; //打印节点名称和节点值
//            file_put_contents($file, $result, FILE_APPEND | LOCK_EX);
//        }
        file_put_contents($file, "\r\n\r\n\r\n", FILE_APPEND | LOCK_EX);
    }

    public function ebslog(){
        $file = fopen("log.txt", "r") or die("Unable to open file!");
        echo fread($file,filesize("log.txt"));
        fclose($file);
    }
}
