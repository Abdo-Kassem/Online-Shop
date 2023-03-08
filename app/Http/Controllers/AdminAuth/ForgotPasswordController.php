<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Traits\SendPasswordResetEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendPasswordResetEmail;
    
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function broker()
    {
        return Password::broker('admins');
    }

    /**
     * 
     * validate email 
     * @param Request $request
     * @return array if email achieve rule and retuen errors to form else
     */

     private function validateEmail(Request $request)
     {
        return $request->validate(['email'=>'required|email:rfc,dns']);
     }
    
    public function sendResetLinkEmail(Request $request)
    {
        
        $this->validateEmail($request);

        $this->createUrl();

        $status = $this->sendPasswordReset($request);
        
        return $status === Password::RESET_LINK_SENT? redirect()->back()->with('status',__($status)):
                            redirect()->back()->withErrors(['email' => __($status)]);
    }

    private function createUrl(){

        ResetPassword::$createUrlCallback = function($notifiable,$token){
            $url = url(route('admin.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]),false);
            return str_replace(['?token=','&email='],['/','/'],$url);
        };
    }

}
