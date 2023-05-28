<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SellerServices;

class SellerSetting extends Controller
{

    private $seller;

    public function __construct(SellerServices $seller)
    {
        $this->seller = $seller;
    }


    public function index($type=0)
    {
        $sellers = $this->seller->getAllByType($type);
        return view('admin.seller.show_seller',compact('sellers'));
    }

    public function deleteSeller($sellerID)
    {
        if($this->seller->destroy($sellerID))
            return redirect()->back()->with('success','deletion done');
        return redirect()->back()->with('fail','deletion fail');
    }

    public function activeSeller($sellerID)
    {
        if($this->seller->activeSeller($sellerID))
            return redirect()->back()->with('success','seller agree done');
        return redirect()->back()->with('fail','seller agree done');
    }
}
