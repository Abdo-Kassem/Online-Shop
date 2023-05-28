<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use App\Http\Controllers\Controller;
use App\Services\OrderServices;
use App\Traits\CalculateNewPrice;
use Illuminate\Support\Facades\Auth;

class Order extends Controller
{
    use CalculateNewPrice;

    private $order;

    public function __construct(OrderServices $order)
    {
        $this->middleware('auth:web');
        $this->order = $order;
    }

    public function index()
    {
        $user = Auth::user();
        $userItemsCount = Basket::counts($user);
        $orders = $this->order->getOrdersBy($user);
        return view('site.showOrders',compact('orders','userItemsCount'));
    }
    
    public function createOrder(){

        $user = Auth::user();

        if($this->order->store($user)){
            return redirect()->back()->with('success','2 orders created ');
        }
        return redirect()->back()->with('fail','fail try again');
    }

    public function cancel($orderID)
    {
        if($this->order->destroy($orderID))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','deletion fail try again');
    }

}
