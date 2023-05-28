<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemUpdateValidator;
use App\Http\Requests\ItemValidator;
use App\Services\CategoryServices;
use App\Services\ItemServices;
use App\Services\SubCategoryServices;

class ItemSetting extends Controller
{

    private $item;

    public function __construct(ItemServices $item)
    {
        $this->item = $item;
    }

    public function index()
    {
        $items = $this->item->all();     
        return view('admin.item.show_items',compact('items'));
    }
    
    public function edite($itemId)
    {
        $item = $this->item->getByID($itemId,null,true);
        return view('admin.item.edite',compact('item'));
    }

    public function update(ItemUpdateValidator $request)
    {        
        if($this->item->update($request))
            return redirect()->back()->with('success','done');

        return redirect()->back()->with('fail','please try again');

    } 

    public function create()
    {
        $categoriesAndSubcategories = (new CategoryServices(new SubCategoryServices))->getCategoriesAndChields();
        return view('admin.item.create',compact('categoriesAndSubcategories'));
    }


    public function save(ItemValidator $request)
    {   
        if($this->item->store($request))
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','error try again');
    }

    public function destroy($itemId)
    {    
        return $this->redirectBack($this->item->destroy($itemId));
    }

    private function redirectBack($status)
    {
        if($status)
            return redirect()->back()->with('success','done');
        return redirect()->back()->with('fail','sorry try again');
    }
}
