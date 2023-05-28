<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Services\SubCategoryServices;



class SubCategory extends Controller
{

    public function getSupCategory($subCateID)
    {
        
        $categoryName = '';

        $subCategoryData = (new SubCategoryServices)->getSupCategory($subCateID,$categoryName);
        
        return view('site.subCategory.displaySubcategory',compact('subCategoryData','categoryName'));

    }
    
}
