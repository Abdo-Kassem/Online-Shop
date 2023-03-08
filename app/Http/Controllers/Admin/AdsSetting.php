<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Services\AdsServices;
use App\Services\ItemServices;

class AdsSetting extends Controller
{
    public function showItems()
    {
        $items = AdsServices::displayCandidate();
        return view('admin.ads.show_available_items',compact('items'));
    }

    public function save($itemID)
    {
        if(!AdsServices::save($itemID))
            return redirect()->back()->with('fail','item not found');
        return redirect()->back()->with('success','done');
    }

    public function show()
    {
        $ads = AdsServices::all();
        return view('admin.ads.show_ads',compact('ads'));
    }

    public function delete($adsID)
    {
        if(AdsServices::delete($adsID))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','ads not found');
    }

}
