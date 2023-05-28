<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Shop;
use App\Services\CategoryServices;
use App\Services\ShopServices;
use Illuminate\Support\Facades\Auth;

class SellerExpenses extends Controller
{
    public function index()
    {
        $sellerID = Auth::guard('seller')->id();
        
        $shops = Shop::select(['category_id'])->where('sellerID',$sellerID)->get(); //return categories id
        
        $categoriesDate = [];

        foreach($shops as $shop){
            $categoriesDate[] = Category::findorfail($shop->category_id);
        }
        
        return view('site.selling.selling_expenses',compact('categoriesDate'));

    }
}
