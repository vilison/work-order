<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$status=1)
    {
        //
        //echo 'index';
        //$status = empty($request->status)?1:$request->status;
        $users = User::status($status)->recent()->get();
        return view('user.index',array('users'=>$users,'status'=>$status));
    }

    public function info(){
        $user = Auth::user();
        return view('user.info',array('email'=>$user->email,'listrow'=>$user->listrow));
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
            'name.unique' => '登录名已存在！',
            'name.required' => '请填写登录名！',
            'email.required' => '请填写邮箱！',
            'email.unique' => '邮箱已存在！',
        );
        $validator = $this->getValidationFactory()->make($input,[
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users',
            'password' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return $messages;
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
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

    public function leave(Request $request){
        $id = $request->id;
        $user = User::findOrFail($id);
        $user->status = 2;
        return $user->save();
    }

    public function upwd(Request $request){
        $input = $request->all();
        $messages = array(
            'password.required' => '请填写密码！',
        );
        $validator = $this->getValidationFactory()->make($input,[
            'password' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return $messages;
        }

        $id = $request->id;
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function updatepwd(Request $request){
        $user = Auth::user();
        $user = User::findOrFail($user->id);
        if(!Hash::check($request->oldpassword, $user->password)){
            $data['result'] = false;
            $data['msg'] = '原密码错误';
            return json_encode($data);
        }
        $user->password = Hash::make($request->newpassword);
        $user->save();
        $data['result'] = true;
        $data['msg'] = '修改成功';
        return json_encode($data);
    }

    public function updateemail(Request $request){
        $user = Auth::user();
        $user->email = $request->email;
        $user->save();
        $data['result'] = true;
        $data['msg'] = '修改成功';
        return json_encode($data);
    }

    public function updatelr(Request $request){
        $user = Auth::user();
        $user->listrow = $request->listrow;
        $user->save();
        $data['result'] = true;
        $data['msg'] = '修改成功';
        return json_encode($data);
    }
}
