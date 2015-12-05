<?php

namespace App\Http\Controllers;

use App\Nhserver;
use App\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $setting = Setting::findOrFail(1);
        $nhservers = Nhserver::all();
        return view('setting.index',array(
            'setting'=>$setting,
            'nhservers' => $nhservers
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
    public function usn(Request $request)
    {
        //
        $id=1;
        $setting = Setting::find($id);
        $setting->supplier_number = $request->supplier_number;
        $setting->save();
        echo 1;
    }

    public function usend(Request $request)
    {
        //
        $id=1;
        $setting = Setting::find($id);
        $setting->mail_server = $request->mail_server;
        $setting->mail_server_port = $request->mail_server_port;
        $setting->mail_account = $request->mail_account;
        $setting->mail_password = $request->mail_password;
        $setting->save();
        echo 1;
    }

    public function ucrm(Request $request)
    {
        //
        $id=1;
        $setting = Setting::find($id);
        $setting->crm_server = $request->crm_server;
        $setting->crm_server_port = $request->crm_server_port;
        $setting->crm_account = $request->crm_account;
        $setting->crm_password = $request->crm_password;
        $setting->timeout = $request->timeout;
        $setting->warn_timeout = $request->warn_timeout;
        $setting->save();
        echo 1;
    }

    public function utime(Request $request)
    {
        //
        $id=1;
        $setting = Setting::find($id);
        $setting->refresh_interval = $request->refresh_interval;
        $setting->warn_timeout = $request->warn_timeout;
        $setting->save();
        echo 1;
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
