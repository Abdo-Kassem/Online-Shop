<?php

namespace App\Traits;

use App\Models\SupCategory;

Trait GetSubCategoryItems
{

   public function getSubcategorisItems(SupCategory $subCategory)
   {

      $items = $subCategory->items()->paginate(PAGINATION);
        foreach($items as $item){
            $item->discount;
            if($item->discount != null){
                $item->newPrice = $this->calcNewPrice($item->discount->discount_value,$item->price);
            }
        }
        return $items;
        
   }

}
