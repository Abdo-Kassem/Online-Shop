<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderServices;
use App\Services\SellerServices;

class AdminHome extends Controller
{
    private $order , $seller;

    public function __construct(OrderServices $order,SellerServices $seller)
    {
        $this->order = $order;
        $this->seller = $seller;
    }

    public function index()
    {
        
        $order = $this->order->getlastOrder();

        $seller = $this->seller->getLastSeller();

        $orderNumber = $this->order->orderCount();

        $sellerNumber = $this->seller->getSellerNumber();

        $sellerDisabledNumber = $this->seller->getDisabledSellerNumber();

        return view('admin.home',compact('order','seller','orderNumber','sellerNumber','sellerDisabledNumber'));
    
    }

    
}
