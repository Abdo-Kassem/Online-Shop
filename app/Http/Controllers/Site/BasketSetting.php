<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Items;
use App\Models\SupCategory;
use App\Services\SubCategoryServices;
use App\Traits\CalculateNewPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketSetting extends Controller
{
    use CalculateNewPrice;

    protected $user;
    protected $basket;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::guard('web')->user();
            $this->basket = new Basket($this->user);
            return $next($request);
        });
        
    }

    public function getBasket()
    {
        $items = $this->basket->all();
        $totalPrice = 0;
       
        foreach($items as $key=>$item){
            
            $requestItemCount = $this->basket->requestItemCount($item);

            if($item->item_number >=  $requestItemCount){
                
                $item->namespace = Category::select('name')->findorfail(
                    SupCategory::select('category_id')->findOrFail($item->subcategory_id)->category_id
                )->name;

                $item->item_count = $requestItemCount;

                if($item->discount != null){

                    $item->newPrice = static::calcNewPrice($item->discount->discount_value,$item->price);
                    $totalPrice += $item->newPrice;
                    $totalPrice *=$item->item_count;

                }else{

                    $totalPrice += $item->price;
                }

            }else {
                $this->basket->delete($item);
            }

        }

        $userItemsCount = $this->basket->count();

        return view('site.cart',compact('items','totalPrice','userItemsCount'));

    }

    public function addToBasket($itemId){

        $item = Items::findOrFail($itemId);
       
             //([$itemId =>['item_count'=>1]]);
        if(count( $this->basket->add($item)['attached'])>0){
            return redirect()->back()->with('success','item added successfully');
        }else{
            return redirect()->back()->with('fail','item already exist in cart');
        }
    }

    public function delete($itemId){
        
        $item = Items::findOrFail($itemId);
        $res = $this->basket->delete($item);
        if($res==1){
            return redirect()->back()->with('success','item deleted successfully');
        }else{
            return redirect()->back()->with('fail','item not delete from cart');
        }
    }

    public function plus(Request $request)
    {
        $item = Items::findorfail($request->itemID);
        $userItemPivot = $this->basket->getByID($request->itemID);
       //check if item number satisfy this operation
        if($item->item_number > $userItemPivot->pivot->item_count) {
            
            if($this->basket->plus($userItemPivot)){
                return redirect()->back()->with('plus-message','item quantity increased successfully');
            }else{
                return redirect()->back()->with('plus-message','item quantity increasing fail');
            }

        }else {
            return redirect()->back()->with('plus-message','number of item can\'t satisfy your request');
        }
        
    }

    public function minus($itemID){

        $item = Items::select('id')->findorfail($itemID);
        
        if($this->basket->minus($item)){

            return redirect()->back()->with('success','item quantity decreased successfully');

        }else{

            return redirect()->back()->with('fail','item quantity decreasing fail');
            
        }

    }


}
