<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Services\AdsServices;
use App\Services\ItemServices;

class AdsSetting extends Controller
{

    private $ads;

    public function __construct(AdsServices $ads)
    {
        $this->ads = $ads;
    }


    public function showItems()
    {
        $items = $this->ads->displayCandidate();
        return view('admin.ads.show_available_items',compact('items'));
    }

    public function save($itemID)
    {
        if(!$this->ads->save($itemID))
            return redirect()->back()->with('fail','item not found');
        return redirect()->back()->with('success','done');
    }

    public function show()
    {
        $ads = $this->ads->all();
        return view('admin.ads.show_ads',compact('ads'));
    }

    public function delete($adsID)
    {
        if($this->ads->delete($adsID))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','ads not found');
    }

}
