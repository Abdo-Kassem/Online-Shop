<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Services\OrderServices;
use Illuminate\Support\Facades\Auth;

class OrderSetting extends Controller
{
    private $sellerID ;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->sellerID = Auth::guard('seller')->id();
            return $next($request);
        });
    }

    public function showOrders()
    {
        $orders = OrderServices::getWhere('sellerID','=',$this->sellerID);

        foreach($orders as $order){
            $order->userName = OrderServices::getUserName($order);
        }
    
        return view('site.selling.order.show_orders',compact('orders'));
    }

    public function itemOfOrder($orderID)
    {
        $items = OrderServices::getItemsOfOrder($orderID,true);
        $items->orderID = $orderID;
        return view('site.selling.order.show_items_of_order',compact('items'));
    }

}
