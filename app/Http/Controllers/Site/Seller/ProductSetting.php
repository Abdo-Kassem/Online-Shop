<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemUpdateValidator;
use App\Http\Requests\SellerItemValidator;
use App\Services\ItemServices;
use Illuminate\Support\Facades\Auth;

class ProductSetting extends Controller
{
    private $sellerID ;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->sellerID = Auth::guard('seller')->id();
            return $next($request);
        });
    }

    public function getProducts()
    {
        $items = ItemServices::allItemsWhere('seller_id','=',$this->sellerID,true);
        return view('site.selling.product.show_products',compact('items'));
    }

    public function edite($itemID)
    {
        $product = ItemServices::edite($itemID);
        return view('site.selling.product.edite',compact('product'));
    }

    public function update(ItemUpdateValidator $request)
    {
        $status = ItemServices::update($request);
        if(gettype($status) === 'string')
            return redirect()->back()->with('faile',$status);
        if($status)
            return redirect()->back()->with('success','done');
        else
            return redirect()->back()->with('fail','try again');    

    }

    public function productDestroy($productID)
    {
        $status = ItemServices::destroy($productID);
    
        if($status === true)
            return redirect()->back()->with('success','done');
        else 
            return redirect()->back()->with('fail',$status);

    }

    public function productPlusOne($productID)
    { 
        if(ItemServices::plusOne($productID))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','sorry try again');
    }

    public function productMinusOne($itemID)
    {
        if(ItemServices::minusOne($itemID))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','sorry try again');
    }

    public function create()
    {
        $shopAndcategoryAndSubcategories = ItemServices::create($this->sellerID);
        return view('site.selling.product.create',compact('shopAndcategoryAndSubcategories'));
    }

    public function store(SellerItemValidator $request)
    {
        $status = ItemServices::store($request,$this->sellerID,false);
        if(!$status)
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('success','done');
    }
    
}
