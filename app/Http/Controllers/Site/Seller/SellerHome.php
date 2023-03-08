<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Services\FeedbackServices;
use App\Services\ItemServices;
use App\Services\OrderServices;
use App\Services\SellerServices;
use Illuminate\Support\Facades\Auth;

class SellerHome extends Controller
{

    private $sellerID ;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->sellerID = Auth::guard('seller')->id();
            return $next($request);
        });
    }

    public function index()
    {
        $totalPrice = SellerServices::getSalesSum($this->sellerID);

        $orderCount = OrderServices::getOrderNumber($this->sellerID);

        $productsCount = ItemServices::countWhere('seller_id','=',$this->sellerID);
        
        $customerCount = SellerServices::countCustomers(SellerServices::getByID($this->sellerID,['id']));

        $lastTwoOrder = OrderServices::getLastTwoOrder($this->sellerID);

        $lastFeedback = FeedbackServices::getLastFeedback($this->sellerID);

        return view('site.selling.home',compact('totalPrice','orderCount','productsCount',
            'customerCount','lastTwoOrder','lastFeedback',))->with('sellerID',$this->sellerID);
    }
    
}
