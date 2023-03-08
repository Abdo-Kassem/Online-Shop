<?php

namespace App\Http\Controllers\Site\SellerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;

class LogoutController extends Controller
{

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('seller');
    }

    public function logoutToPath()
    {
        return 'start-now';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        session()->invalidate();
        return redirect()->to($this->logoutToPath());
    }

}
