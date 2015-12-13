<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{

    protected $redirectAfterLogout = '/auth/login';
    protected $redirectPath  = '/ticket/index';
    protected $loginPath = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $name = $request->name;
        $password = $request->password;
        $data = array();
        if (Auth::attempt(['name' => $name, 'password' => $password,'status'=>1])) {
            // Authentication passed...
            //return redirect($this->redirectPath);
            $data['msg'] = '登录成功';
            $data['result'] = true;
            $data['url'] = $this->redirectPath;
        }else{
            //return redirect($this->loginPath);
            $data['msg'] = '用户名或密码错误';
            $data['result'] = false;
        }
        return json_encode($data);
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
