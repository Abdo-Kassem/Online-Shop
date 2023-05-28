<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use  App\Http\Controllers\Controller;
use App\interfaces\ServicesContract;
use App\Services\AdsServices;
use App\Services\CategoryServices;
use App\Services\ItemServices;
use App\Services\SubCategoryServices;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $Category,$item;

    public function __construct(CategoryServices $Category,ItemServices $item)
    {
        $this->Category = $Category;
        $this->item = $item;
    }

    public function index()
    {

        $cats = $this->Category->getCategoriesAndChields();

        $topSelling = $this->Category->getTopSellingItems($cats); //top selling of subcategories

        $categoryTopSelling = $this->Category->getTopSellingItems($cats);

        $topDiscountItems = $this->item->getHasTopDiscount(6);

        $itemsSlider = (new AdsServices)->getItemsSlider(6); 
       
        $freeShipping = $this->item->getFreeShippingNationalWide();//$this->getFreeShippingNationalWide();

        $userItemsCount = null;

        if(Auth::user())
            $userItemsCount = Basket::counts(Auth::user());
        
        return view('site.index',compact('cats','topDiscountItems','userItemsCount','itemsSlider'
                    ,'freeShipping','topSelling','categoryTopSelling'));
    }
    
    
    

    
    
}
