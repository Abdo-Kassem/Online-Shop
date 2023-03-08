<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use  App\Http\Controllers\Controller;
use App\Services\AdsServices;
use App\Services\CategoryServices;
use App\Services\ItemServices;
use App\Services\SubCategoryServices;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $cats = CategoryServices::getCategoriesAndChields();

        $topSelling = $this->getTopSellingItems($cats); //top selling of subcategories

        $categoryTopSelling = $this->getCateTopSellingItems($cats);

        $topDiscountItems = ItemServices::getHasTopDiscount(6);

        $itemsSlider = AdsServices::getItemsSlider(6); 
       
        $freeShipping = ItemServices::getFreeShippingNationalWide();//$this->getFreeShippingNationalWide();

        $userItemsCount = null;

        if(Auth::user())
            $userItemsCount = Basket::counts(Auth::user());
        
        return view('site.index',compact('cats','topDiscountItems','userItemsCount','itemsSlider'
                    ,'freeShipping','topSelling','categoryTopSelling'));
    }
    
    
    private function getTopSellingItems($cats)
    {
        $topSelling = [];
        if($cats !== null){
            foreach($cats as $cat){
                foreach($cat->supCategories as $subCategory){

                    $topSelling[$subCategory->name] = SubCategoryServices::subCatgoryTopSellingItems(
                        $subCategory->id
                    );
                    
                }
            } 
        }

        return $topSelling;
    }

    private static function getCateTopSellingItems($cats)
    {
        $count = $cats->count();

        if($count>0){
            return CategoryServices::catgoryTopSellingItems($cats[mt_rand(0,$count-1)]->id);
        }

        return null;
    }
    
}
