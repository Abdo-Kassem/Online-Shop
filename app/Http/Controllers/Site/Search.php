<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Traits\CalculateNewPrice;
use Illuminate\Http\Request;

class Search extends Controller
{
    use CalculateNewPrice;
    
    public function search(Request $request){
        
        $items = Items::where('name','like','%'.$request->data.'%')->get();//return collection
        if(!$items->isEmpty()){
            foreach($items as $item){
                $item->supCategory->category;
                $item->discount;
                if($item->discount != null){
                    $item->newPrice = $this->calcNewPrice($item->discount->discount_value,$item->price);
                }
            }
        }
        return view('site.showSearchResult',compact('items'));
    }
}
