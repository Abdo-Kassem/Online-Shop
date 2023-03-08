<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Services\CustomerServices;
use App\Services\SellerServices;
use Illuminate\Support\Facades\Auth;

class CustomerManage extends Controller
{
    private Seller $seller;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->seller = Auth::guard('seller')->user();
            return $next($request);
        });
    }

    public function getCustomer()
    {
        $customers = SellerServices::getCustomer($this->seller,['name as customerName']);
        return view('site.selling.show_customer',compact('customers'));
    }

    public function removeCustomer($customerID)
    {

        if(CustomerServices::destroy($customerID,$this->seller->id));
            return redirect()->back()->with('success','done');
             
        return redirect()->back()->with('fail','please try again');
        
    }

    public function getCustomerFeedback()
    {

        $customers = CustomerServices::getCustomerFeedback($this->seller);  

        return view('site.selling.show_feedback',compact('customers'));

    }
}
