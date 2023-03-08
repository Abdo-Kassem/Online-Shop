<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Services\SellerServices;
use Illuminate\Support\Facades\Auth;

class AnalyzeWeek extends Controller
{

    public function analyzeYourWeek()
    {

        $sellerID = Auth::guard('seller')->id();

        $orders = SellerServices::analyzeWeek($sellerID);

        return view('site.selling.analyze_week',compact('orders'));

    }

}
