<?php

namespace App\Http\Controllers;

use App\Log;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $operator = $request->input('operator', '');
        $bdate = $request->input('bdate', '');
        $edate = $request->input('edate', '');
        $key = $request->input('key', '');
        $users = User::all();
        $logs = Log::operator($operator)->key($key)->between($bdate,$edate)->recent()->paginate(15);
        return view('log.index',array(
            'operator'=>$operator,
            'bdate'=>$bdate,
            'edate'=>$edate,
            'key'=>$key,
            'logs'=>$logs,
            'users'=>$users
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

    public function download(Request $request){
        $date = $request->input('date', date('Y-m-d H:i:s'));
        $logs = Log::dayBefore($date)->get();
        $heads = ['日期','操作人','动作'];
        $cellData[] = $heads;
        foreach($logs as $log){
            $cell = [$log->created_at,$log->operator,$log->action];
            $cellData[] = $cell;
        }
        Excel::create(time(),function($excel) use ($cellData){
            $excel->sheet('data', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    public function deletelog(Request $request){
        $date = $request->input('date', date('Y-m-d H:i:s'));
        Log::dayBefore($date)->delete();
        echo json_encode("1");
    }
}
