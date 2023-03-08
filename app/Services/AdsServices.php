<?php

namespace App\Services;

use App\Models\Ads;
use App\Models\Items;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator as PaginationPaginator;

class AdsServices{

    public static function displayCandidate()
    {
    
       $items = Items::with(['discount'=>function($q){$q->select(['discount_value','item_id']);}])
                ->paginate(5);

        $items = $items->getCollection(); //return collection from LengthAwarePagination object
        foreach($items as $itemKey=>$itemValue){

            if(Ads::where('item_id',$itemValue->id)->exists()){
                $items->forget($itemKey);
            }else{
                $itemValue->namespace = SubCategoryServices::getParent(
                    SubCategoryServices::getByID($itemValue->subcategory_id)
                );
            }

        }

        $currentPage = PaginationPaginator::resolveCurrentPage();
        $options = ['path'=>PaginationPaginator::resolveCurrentPath()];
        $items = new LengthAwarePaginator( $items,$items->count(),5,$currentPage,$options);
        return $items;
    }

    public static function save($itemID)
    {
        if(! ItemServices::itemExist($itemID))
            return false;

        Ads::insert(['item_id'=>$itemID]);
        return true;
    }

    public static function all($byPagination = true)
    {
        $ads = Ads::select('item_id')->get();
        if($byPagination)
            $items = Items::with(['discount'=>function($q){$q->select('discount_value','item_id');}])
            ->whereIn('id',$ads)->paginate(5);
        else
            $items = Items::with(['discount'=>function($q){$q->select('discount_value','item_id');}])
            ->whereIn('id',$ads)->get();

        foreach($items as $item){
            $item->namespace = SubCategoryServices::getParent(
                SubCategoryServices::getByID($item->subcategory_id,['category_id'])
            );
        }
        return $items;
    }

    public static function delete($itemID)
    {
        if(static::adsExist($itemID)){
            return Ads::where('item_id',$itemID)->delete();
        }
        return 0;
    }

    public static function adsExist($itemID):bool
    {
        return Ads::where('item_id',$itemID)->exists();
    }

    public static function getItemsSlider()
    {
       return static::all(false);
    }
    
}