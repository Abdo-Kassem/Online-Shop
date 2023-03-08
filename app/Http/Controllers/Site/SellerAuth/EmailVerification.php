<?php

namespace App\Http\Controllers\Site\SellerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmailVerification extends Controller
{
    public function verifyEmail($token)
    {
        $verify = DB::table('seller_verify')->where('token',$token)->first();
        if($verify){
            $seller = DB::table('sellers')->where('id',$verify->seller_id)->first();
            
            if($seller->seller_verify === 0){

                DB::table('sellers')->update(['seller_verify'=>1]);

            }

            return redirect()->route('seller.home');

        }else{
            session()->invalidate();
            return redirect()->route('seller.register.form');
        }
    }
}
