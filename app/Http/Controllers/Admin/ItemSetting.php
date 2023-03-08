<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemUpdateValidator;
use App\Http\Requests\ItemValidator;
use App\Services\CategoryServices;
use App\Services\ItemServices;

class ItemSetting extends Controller
{

    public function index()
    {
        $items = ItemServices::all();     
        return view('admin.item.show_items',compact('items'));
    }
    
    public function edite($itemId)
    {
        $item = ItemServices::getByID($itemId,null,true);
        return view('admin.item.edite',compact('item'));
    }

    public function update(ItemUpdateValidator $request)
    {        
        if(ItemServices::update($request))
            return redirect()->back()->with('success','done');

        return redirect()->back()->with('fail','please try again');

    } 

    public function create()
    {
        $categoriesAndSubcategories = CategoryServices::getCategoriesAndChields();
        return view('admin.item.create',compact('categoriesAndSubcategories'));
    }
    public function save(ItemValidator $request)
    {   
        if(ItemServices::store($request))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','error try again');
    }

    public function destroy($itemId)
    {    
        return $this->redirectBack(ItemServices::destroy($itemId));
    }

    private function redirectBack($status)
    {
        if($status)
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','sorry try again');
    }
}
