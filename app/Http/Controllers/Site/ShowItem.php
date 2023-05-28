<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use App\Http\Controllers\Controller;
use App\Services\ItemServices;
use App\Traits\CalculateNewPrice;
use Illuminate\Support\Facades\Auth;

class ShowItem extends Controller
{
    use CalculateNewPrice;

    private $item;

    public function __construct(ItemServices $item)
    {
        $this->item = $item;
    }
    
    public function index($item_id)
    {
        $item = $this->item->getItemDataToDisplay($item_id);
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
