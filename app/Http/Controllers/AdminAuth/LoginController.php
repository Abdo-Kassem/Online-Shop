<?php

namespace App\Http\Controllers\AdminAuth;


use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLogin;
use App\Http\Requests\LoginValidator;
use App\Traits\AdminLogin as TraitsAdminLogin;


class LoginController extends Controller
{
    use TraitsAdminLogin;

    /** 
     * Where to redirect users after login .
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(AdminLogin $request)
    {
        return $this->adminLogin($request);
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    
    public function redirectTo() {

        if(str_contains(redirect()->intended()->getTargetUrl(),'admin'))
            return redirect()->intended();
        return redirect()->to('admin/home');
    }

}
