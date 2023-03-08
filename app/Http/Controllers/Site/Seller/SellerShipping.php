<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SellerShipping extends Controller
{
    public function index(){
        $sellerName = Auth::guard('seller')->user()->name;
        return view('site.selling.shipping')->with('sellerName',$sellerName);
    }
}
