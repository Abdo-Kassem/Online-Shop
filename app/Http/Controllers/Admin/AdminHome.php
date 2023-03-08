<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderServices;
use App\Services\SellerServices;

class AdminHome extends Controller
{
    
    /**
     * get admin home page data
     * 
     */
    public function index()
    {
        
        $order = OrderServices::getlastOrder();

        $seller = SellerServices::getLastSeller();

        $orderNumber = OrderServices::getOrderNumber();

        $sellerNumber = SellerServices::getSellerNumber();

        $sellerDisabledNumber = SellerServices::getDisabledSellerNumber();

        return view('admin.home',compact('order','seller','orderNumber','sellerNumber','sellerDisabledNumber'));
    
    }

    
}
