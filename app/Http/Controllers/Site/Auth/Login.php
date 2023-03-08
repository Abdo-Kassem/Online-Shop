<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginValidator;
use App\Traits\Login as TraitsLogin;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    use TraitsLogin;

    public $loginRoute;

    public function __construct()
    {
        $this->middleware('guest:web');
        $this->loginRoute = 'login';
    }

    public function getForm()
    {
        return view('site.auth.login');
    }

    public function login(LoginValidator $request)
    {
       return $this->log_in($this->credential($request));
    }

    private function credential($request)
    {
        return $request->except('_token');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    private function redirectTo()
    {
        return redirect()->intended();
    }
}
