<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemUpdateValidator;
use App\Http\Requests\SellerItemValidator;
use App\Services\ItemServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSetting extends Controller
{
    private $sellerID ,$item;

    public function __construct(ItemServices $item)
    {
        $this->middleware(function ($request, $next) {
            $this->sellerID = Auth::guard('seller')->id();
            return $next($request);
        });

        $this->item = $item;
    }

    public function getProducts()
    {
        $items = $this->item->allItemsWhere('seller_id','=',$this->sellerID,true);
        return view('site.selling.product.show_products',compact('items'));
    }

    public function edite($itemID)
    {
        $product = $this->item->edite($itemID);
        return view('site.selling.product.edite',compact('product'));
    }

    public function update(ItemUpdateValidator $request)
    {
        $status = $this->item->update($request);
        if(gettype($status) === 'string')
            return redirect()->back()->with('faile',$status);
        if($status)
            return redirect()->back()->with('success','done');
        else
            return redirect()->back()->with('fail','try again');    

    }

    public function create()
    {
        $shopAndcategoryAndSubcategories = $this->item->create($this->sellerID);
        return view('site.selling.product.create',compact('shopAndcategoryAndSubcategories'));
    }

    public function store(SellerItemValidator $request)
    {
        $status = $this->item->store($request,$this->sellerID,false);
        if(!$status)
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('success','done');
    }

    public function productDestroy($productID)
    {
        $status = $this->item->destroy($productID);
    
        if($status === true)
            return redirect()->back()->with('success','done');
        else 
            return redirect()->back()->with('fail',$status);

    }

    public function productPlusOne($productID)
    { 
        if($this->item->plusOne($productID))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','sorry try again');
    }

    public function productMinusOne($itemID)
    {
        if($this->item->minusOne($itemID)!==false)
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','sorry try again');
    }
    
}
