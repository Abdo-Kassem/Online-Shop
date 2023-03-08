<?php

namespace App\Basket;

use App\Models\Items;
use App\Models\User;
use App\Models\User_item_cart_pivot;

class Basket{

    protected $items;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->items = $this->fillBasket($user);
        
    }

    public function fillBasket(User $user)
    {
        return $user->items;
    }

    public function add(Items $item)
    {
        $this->items->push($item);
        return $item->users()->syncWithoutDetaching([$this->user->id =>['item_count'=>1]]);
    }

    public function delete(Items $item):int
    {
        if( $this->count()){

            foreach($this->items as $key=>$value){
                if($value->id === $item->id)
                    $this->items->forget($key);
            }
    
            return $item->users()->detach($this->user->id);
        }

        return 0;

    }

    /**
     * delete all items from basket and database
     */
    

    public function all()
    {
        
        return $this->items;
    }

    public function count() :int
    {
        return $this->items->count(); 
    }

    public static function counts(User $user)
    {
        return $user->items()->count();
    }

    public function requestItemCount(Items $item) :int
    {
        foreach($this->items as $item){
            if($item->id === $item->id)
                return $item->pivot->item_count;
        }
        abort(404,'item not found');
    }

    public function plus(Items $item)
    {
        foreach($this->items as $itemList){
        
            if($itemList->id === $item->id){
                $itemList->pivot->item_count ++;   

                $itemPivot = User_item_cart_pivot::where('item_id',$item->id)->
                where('user_id',$this->user->id)->first();

                $itemPivot->item_count++;
                return $itemPivot->save();
            }
            return 0;
        }
    }

    public function minus(Items $item)
    {
        foreach($this->items as $key=>$itemList){
        
            if($itemList->id === $item->id){

                $this->items->forget($key);

                if($itemList->pivot->item_count == 1){
                    $itemList->users()->detach($this->user->id);
                }

                $itemPivot = User_item_cart_pivot::where('item_id',$item->id)->
                where('user_id',$this->user->id)->first();

                $itemPivot->item_count--;
                return $itemPivot->save();
            }
            return 0;
        }
    }


    public function getByID($itemID)
    { 
        foreach($this->items as $item){

            if($item->id == $itemID)
                return $item;

        }
        return null;
    }

}