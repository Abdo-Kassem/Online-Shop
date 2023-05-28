<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Services\HomeSellerService;
use App\Services\SellerServices;
use Illuminate\Support\Facades\Auth;

class SellerHome extends Controller
{

    private $sellerID ,$sellerHome;

    public function __construct(HomeSellerService $sellerHome)
    {
        $this->sellerHome = $sellerHome;

        $this->middleware(function ($request, $next) {
            $this->sellerID = Auth::guard('seller')->id();
            return $next($request);
        });
    }

    public function index()
    {
        $totalPrice = $this->sellerHome->getSalesSum($this->sellerID);

        $orderCount = $this->sellerHome->getOrderNumber($this->sellerID);

        $productsCount = $this->sellerHome->itemCount($this->sellerID);
        
        $customerCount = $this->sellerHome->countCustomers((new SellerServices)->getByID($this->sellerID,['id']));

        $lastTwoOrder = $this->sellerHome->getLastTwoOrder($this->sellerID);

        $lastFeedback = $this->sellerHome->getLastFeedback($this->sellerID);

        return view('site.selling.home',compact('totalPrice','orderCount','productsCount',
            'customerCount','lastTwoOrder','lastFeedback',))->with('sellerID',$this->sellerID);
    }
    
}
