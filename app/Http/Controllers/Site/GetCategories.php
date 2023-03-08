<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use  App\Http\Controllers\Controller;
use App\Services\CategoryServices;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;

class GetCategories extends Controller
{

    public function getCategory($categoryId)
    {
        $user = Auth::user();
        if($user !== null)
            $userItemsCount = Basket::counts($user);
        $userItemsCount = 0;
        $namespace = ''; //will pass reference
        $subCategories = CategoryServices::getCategory($categoryId,$namespace);

        return view('site.categories.category_show',compact('subCategories','userItemsCount','namespace'));
    }
    
    
    public function getCategoryTopDelas()
    {
        $topDeals = CategoryServices::getCategoryTopDelas();
        return view('site.topDealsAll',compact('topDeals'));
    }
    
}
