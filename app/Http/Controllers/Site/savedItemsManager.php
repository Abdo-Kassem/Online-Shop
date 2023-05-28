<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Services\ItemServices;
use App\Traits\CalculateNewPrice;
use Illuminate\Support\Facades\Auth;

class savedItemsManager extends Controller
{
    use CalculateNewPrice;
    
    private $item;

    public function __construct(ItemServices $item)
    {
        $this->middleware('auth:web');
        $this->item = $item;
    }

    public function addToSavedItems($itemId)
    {
        $user = Auth::user();

        $attached = $user->savedItems()->syncWithoutDetaching($itemId);
        
        if(count($attached['attached'])>0){
            return redirect()->back()->with('saved_success','done');
        }else{
            return redirect()->back()->with('saved_fail','item already exist');
        }

    }

    public function getSavedItems()
    {
        $user = Auth::user();

        $savedItems = $user->savedItems;

        $userItemsCount = Basket::counts($user); //send it to display in cart

        foreach($savedItems as $savedItem){
            $savedItem = $this->item->getItemDataToDisplay($savedItem);
        }

        return view('site.savedItems',compact('savedItems','userItemsCount'));
    }

    public function removeSavedItems($item_id)
    {
        if( ! Items::where('id',$item_id)->exists())
            return abort(404,'item not found');

        $user = Auth::user();
        $user->savedItems()->detach($item_id);

        return redirect()->back();
        
    }

}
