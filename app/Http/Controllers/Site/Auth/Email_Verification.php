<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Email_Verification extends Controller 
{
    public function verifyEmail($token)
    {
        $verify = DB::table('user_verify')->where('token',$token)->first();

        if($verify){

            $user = DB::table('users')->where('id',$verify->user_id)->first();
            
            if($user->user_verify === 0){

                DB::table('sellers')->update(['seller_verify'=>1]);

            }

            return redirect()->intended();

        }else{
            session()->invalidate();
            return redirect()->route('register');
        }
    }
}
