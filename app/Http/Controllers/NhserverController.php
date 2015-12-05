<?php

namespace App\Http\Controllers;

use App\Nhserver;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NhserverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $input = $request->all();
        $messages = array(
            'host.required' => '请填写服务器！',
            'port.required' => '请填写端口！',
            'province.required' => '请填写所在省！',
        );
        $validator = $this->getValidationFactory()->make($input,[
            'host' => 'required',
            'port' => 'required',
            'province' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return $messages;
        }

        $nhserver = new Nhserver;
        $nhserver->host = $request->host;
        $nhserver->port = $request->port;
        $nhserver->province = $request->province;
        $nhserver->save();
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $input = $request->all();
        $messages = array(
            'host.required' => '请填写服务器！',
            'port.required' => '请填写端口！',
            'province.required' => '请填写所在省！',
        );
        $validator = $this->getValidationFactory()->make($input,[
            'host' => 'required',
            'port' => 'required',
            'province' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return $messages;
        }
        $id = $request->id;
        $nhserver = Nhserver::find($id);
        $nhserver->host = $request->host;
        $nhserver->port = $request->port;
        $nhserver->province = $request->province;
        $nhserver->save();
        echo json_encode("1");
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
}
