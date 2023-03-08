<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Services\CategoryServices;
use App\Services\ShopServices;
use Illuminate\Support\Facades\Auth;

class SellerExpenses extends Controller
{
    public function index()
    {
        $sellerID = Auth::guard('seller')->id();
        
        $categories = ShopServices::getBySellerID($sellerID,['category_id']); //return categories id
        
        $categoriesDate = [];

        foreach($categories as $category){
            $categoriesDate[] = CategoryServices::getByID($category->category_id);
        }
        
        return view('site.selling.selling_expenses',compact('categoriesDate'));

    }
}
