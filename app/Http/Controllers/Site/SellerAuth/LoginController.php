<?php

namespace App\Http\Controllers\Site\SellerAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerLoginValidator;
use App\Traits\Login;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use Login;

    public $loginRoute;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:seller');
        $this->loginRoute = 'seller.login';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function showLoginForm()
    {
        return view('site.auth.seller_auth.login');
    }
    
    public function login(SellerLoginValidator $request)
    {
        return $this->log_in($this->credentials($request));
        
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('seller');
    }

    
    protected function credentials(SellerLoginValidator $request)
    {
        return $request->only('email', 'password','id');
    }

    private function redirectTo()
    {
        $intended = redirect()->intended()->getTargetUrl();

        if(str_contains($intended,'seller'))
            return redirect()->intended();
            
        return redirect()->route('seller.home');
    }

}
