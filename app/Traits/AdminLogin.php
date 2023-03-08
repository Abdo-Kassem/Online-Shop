<?php

namespace App\Traits;

use App\Http\Requests\AdminLogin as RequestsAdminLogin;
use Illuminate\Support\Facades\Auth;

trait AdminLogin{

    public function adminLogin(RequestsAdminLogin $request)
    {
        if(Auth::guard('admin')->attempt($request->except('_token'))){

            $redirect = $this->redirectTo();
            $request->session()->regenerate(); //will delete session 
            return $redirect;
        
        }
    }
}