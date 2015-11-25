<?php

namespace App\Http\Controllers;
require __DIR__ . '/../../../vendor/autoload.php';

use App\Order;
use Curl\Curl;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $name = $request->input('name', 'RepairCreateTime');
        $sort = $request->input('sort', 'desc');
        $orders = Order::order($name,$sort)->paginate(10);
        return view('order.index',array(
            'orders'=>$orders,
            'name'=>$name,
            'sort'=>$sort
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
                $order = Order::find($ret->WFormId);
                if(empty($order)){
                    $order = new Order;
                    $order->WFormId = $ret->WFormId;
                    $order->Identifier = $ret->Identifier;
                    $order->WFormSetTime = $ret->WFormSetTime;
                    $order->ReplyDue = $ret->ReplyDue;
                    $order->IsChecked = $ret->IsChecked;
                    $order->ArriveDue = $ret->ArriveDue;
                    $order->WFormContent = $ret->WFormContent;
                    $order->OrgName = $ret->OrgName;
                    $order->InstallAddress = $ret->InstallAddress;
                    $order->ModelId = $ret->ModelId;
                    $order->BrandId = $ret->BrandId;
                    $order->DevManager = $ret->DevManager;
                    $order->DevManagerTel = $ret->DevManagerTel;
                    $order->RepairInfo = json_encode($ret->RepairInfo);
                    $order->Engineer = $ret->RepairInfo->Engineer;
                    $order->RepairCreateTime = $ret->RepairInfo->RepairCreateTime;
                    $order->RespTime = $ret->RepairInfo->RespTime;
                    $order->ArrivalTime = $ret->RepairInfo->ArrivalTime;
                    $order->RepairformSts = $ret->RepairInfo->RepairformSts;
                    $order->MaintianComTel = $ret->RepairInfo->MaintianComTel;
                    $order->GivenArrivalTime = $ret->RepairInfo->GivenArrivalTime;
                    $order->Mobile = $ret->RepairInfo->Mobile;
                    $order->save();
                }
            }
        }
        $curl->close();
    }
}
