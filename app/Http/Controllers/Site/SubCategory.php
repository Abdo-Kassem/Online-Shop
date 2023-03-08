<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Items;
use App\Models\Order_Items_pivot;
use App\Models\SupCategory;
use App\Services\SubCategoryServices;
use App\Traits\CalculateNewPrice;
use App\Traits\GetCategory;


class SubCategory extends Controller
{

    public function getSupCategory($subCateID)
    {
        $categoryName = '';

        $subCategoryData = SubCategoryServices::getSupCategory($subCateID,$categoryName);
        
        return view('site.subCategory.displaySubcategory',compact('subCategoryData','categoryName'));

    }
    
}
