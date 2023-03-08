<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderValidator;
use App\Services\OrderServices;

class OrderSetting extends Controller
{

    public function getOrders()
    {
        $orders = OrderServices::all();
        return view('admin.order.showOrders',compact('orders'));
    }

    public function showOrder($orderID)
    {
        $items = OrderServices::getItemsOfOrder($orderID);
        return view('admin.order.show_items_of_order',compact('items'));
    }

    public function edite($orderID)
    {
        $order = OrderServices::getColumnsByID($orderID,['send_time','id','state']);
        return view('admin.order.edite',compact('order'));
    }
    
    public function update(OrderValidator $request)
    {
        if(OrderServices::update($request)){
            return redirect()->route('orders.show')->with('success','done');
        }
        else 
            return redirect()->back()->with('fail','sorry try again');
    }

}
