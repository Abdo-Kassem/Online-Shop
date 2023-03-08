<?php

namespace App\Traits;

use App\Models\Items;
use App\Models\Order_Items_pivot;
use App\Services\CategoryServices;
use App\Services\SubCategoryServices;
use PhpParser\Builder\Trait_;

Trait TopPicks 
{

    public static function getTopPicksItems($subCategory_id)
    {//will return topPicks five items
       
        $topPicksItemsNum = 0; //will stop foreach that grt top picks item when number of items is 5

        $items = Order_Items_pivot::orderBy('item_id','DESC')->get()->all();
        $topPicksItems = [];
        $topPicks = [];
        $itemsCount = count($items);
        for($count=0;$count<$itemsCount;$count++){
            $topPicks[$items[$count]->item_id]=1;
            for($subCount=($count+1);$subCount<$itemsCount;$subCount++){
                if($items[$count]->item_id==$items[$subCount]->item_id){
                    $topPicks[$items[$count]->item_id] +=1; 
                }else{
                    $count = $subCount-1;
                    break;
                }
            }
        }
        arsort($topPicks); //sort associativ array values by desending and save associative key of values
        foreach($topPicks as $key=>$value){
            $item = Items::where('subcategory_id',$subCategory_id)->find($key);
            if($item && $topPicksItemsNum<5){
                $item->discount = $item->discount()->select(['item_id','discount_value'])->first();
                if($item->discount !=null){
                    $item->newPrice = static::calcNewPrice($item->discount->discount_value,$item->price);
                }
                $item->namespace = SubCategoryServices::getParent(SubCategoryServices::getByID($subCategory_id,['id','category_id']));
                $topPicksItems[] = $item;
                $topPicksItemsNum += 1;
            }
       }
      
       return $topPicksItems;
    }
}
