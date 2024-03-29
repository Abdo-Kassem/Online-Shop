<?php

namespace App\Services;

use App\Models\Ads;
use App\Models\Category;
use App\Models\Items;
use App\Models\SupCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator as PaginationPaginator;

class AdsServices{

    public  function displayCandidate()
    {
    
       $items = Items::with(['discount'=>function($q){$q->select(['discount_value','item_id']);}])
                ->paginate(5);

        $items = $items->getCollection(); //return collection from LengthAwarePagination object

        foreach($items as $itemKey=>$itemValue){

            if(Ads::where('item_id',$itemValue->id)->exists()){

                $items->forget($itemKey);

            }else{

                $itemValue->namespace = $this->getItemNamespace($itemValue);
                   
            }

        }

        $currentPage = PaginationPaginator::resolveCurrentPage();

        $options = ['path'=>PaginationPaginator::resolveCurrentPath()];

        $items = new LengthAwarePaginator( $items,$items->count(),5,$currentPage,$options);

        return $items;

    }

    public  function save($itemID)
    {
        if(! Items::where('id',$itemID)->exists())
            return false;

        Ads::insert(['item_id'=>$itemID]);
        return true;
    }

    public function all($byPagination = true)
    {
        $ads = Ads::select('item_id')->get();
        if($byPagination)
            $items = Items::with(['discount'=>function($q){$q->select('discount_value','item_id');}])
            ->whereIn('id',$ads)->paginate(5);
        else
            $items = Items::with(['discount'=>function($q){$q->select('discount_value','item_id');}])
            ->whereIn('id',$ads)->get();

        foreach($items as $item){
            $item->namespace = $this->getItemNamespace($item);
        }

        return $items;
    }

    public  function delete($itemID)
    {
        if($this->adsExist($itemID)){
            return Ads::where('item_id',$itemID)->delete();
        }
        return 0;
    }

    public  function adsExist($itemID):bool
    {
        return Ads::where('item_id',$itemID)->exists();
    }

    public  function getItemsSlider()
    {
       return $this->all(false);
    }

    public function getItemNamespace($item):string
    {
        return Category::select('name')->findorfail(
                    SupCategory::select('category_id')->findorfail($item->subcategory_id)->category_id
                )->name;
    }
    
}