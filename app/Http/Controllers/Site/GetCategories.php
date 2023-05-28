<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use  App\Http\Controllers\Controller;
use App\Services\CategoryServices;
use Illuminate\Support\Facades\Auth;

class GetCategories extends Controller
{

    private $category;

    public function __construct(CategoryServices $category)
    {
        $this->category = $category;
    }


    public function getCategory($categoryId)
    {
        $user = Auth::user();

        if($user !== null)
            $userItemsCount = Basket::counts($user);

        $userItemsCount = 0;
        $namespace = ''; //will pass reference
        $subCategories = $this->category->getCategory($categoryId,$namespace);

        return view('site.categories.category_show',compact('subCategories','userItemsCount','namespace'));
    }
    
    
    public function getCategoryTopDelas()
    {
        $topDeals = $this->category->getCategoryTopDelas();
        return view('site.topDealsAll',compact('topDeals'));
    }
    
}
