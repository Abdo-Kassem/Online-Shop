<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Services\CustomerServices;
use Illuminate\Support\Facades\Auth;

class CustomerManage extends Controller
{
    private $seller , $customerService;

    public function __construct(CustomerServices $customer)
    {
        $this->middleware(function ($request, $next) {

            $this->seller = Auth::guard('seller')->user();
            return $next($request);

        });

        $this->customerService = $customer;
    }

    public function getCustomer()
    {
        $customers = $this->customerService->getCustomer($this->seller);
        return view('site.selling.show_customer',compact('customers'));
    }

    public function removeCustomer($customerID)
    {

        if($this->customerService->destroy($customerID,$this->seller->id));
            return redirect()->back()->with('success','done');
             
        return redirect()->back()->with('fail','please try again');
        
    }

    public function getCustomerFeedback()
    {

        $customers = $this->customerService->getCustomerFeedback($this->seller);  

        return view('site.selling.show_feedback',compact('customers'));

    }
}
