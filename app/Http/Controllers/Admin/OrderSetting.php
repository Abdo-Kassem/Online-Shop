<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderValidator;
use App\Services\OrderServices;

class OrderSetting extends Controller
{
    private $order;

    public function __construct(OrderServices $order)
    {
        $this->order = $order;
    }

    public function getOrders()
    {
        $orders = $this->order->all();
        return view('admin.order.showOrders',compact('orders'));
    }

    public function showOrder($orderID)
    {
        $items = $this->order->getItemsOfOrder($orderID);
        return view('admin.order.show_items_of_order',compact('items'));
    }

    public function edite($orderID)
    {
        $order = $this->order->getColumnsByID($orderID,['send_time','id','state']);
        return view('admin.order.edite',compact('order'));
    }
    
    public function update(OrderValidator $request)
    {
        if($this->order->update($request)){
            return redirect()->route('orders.show')->with('success','done');
        }
        else 
            return redirect()->back()->with('fail','sorry try again');
    }

}
