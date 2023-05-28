<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Services\OrderServices;
use Illuminate\Support\Facades\Auth;

class OrderSetting extends Controller
{
    private $sellerID , $order;

    public function __construct(OrderServices $order)
    {
        $this->middleware(function ($request, $next) {
            $this->sellerID = Auth::guard('seller')->id();
            return $next($request);
        });

        $this->order = $order;
    }

    public function showOrders()
    {
        $orders = $this->order->getWhere('sellerID','=',$this->sellerID);

        foreach($orders as $order){
            $order->userName = $this->order->getUserName($order);
        }
    
        return view('site.selling.order.show_orders',compact('orders'));
    }

    public function itemOfOrder($orderID)
    {
        $items = $this->order->getItemsOfOrder($orderID,true);
        $items->orderID = $orderID;
        return view('site.selling.order.show_items_of_order',compact('items'));
    }

}
