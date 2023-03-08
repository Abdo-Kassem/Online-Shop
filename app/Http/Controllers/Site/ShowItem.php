<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Services\ItemServices;
use App\Traits\CalculateNewPrice;
use App\Traits\GetCategory;
use App\Traits\GetUserItems;
use Illuminate\Support\Facades\Auth;

class ShowItem extends Controller
{
    use CalculateNewPrice;
    
    public function index($item_id)
    {
        $item = ItemServices::getItemDataToDisplay($item_id);
        $user = Auth::user();
        
        if($user)
            $pageData = [
                'item'=>$item,
                'userItemsCount'=>Basket::counts($user)
            ];
        else
            $pageData = [
                'item'=>$item
            ];

        return view('site.showItem')->with($pageData);
    }
}
