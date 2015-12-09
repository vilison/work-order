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
}
