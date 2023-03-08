<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
   
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
        $this->middleware('guest');
    }
    

    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        return redirect()->route('admin.login.form');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    
    public function redirectTo() {

        return redirect()->intended();
        
    }

}
