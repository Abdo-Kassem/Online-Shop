<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;

class VerificationNotice extends Controller
{
    public function notice(){
        $homeRoute = 'selling';
        $content = 'you must verify email to complete regesteration operation';
        return view('verification_notice\notice',compact('content','homeRoute'));
    }
}
