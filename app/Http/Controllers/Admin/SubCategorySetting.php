<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryValidator;
use App\Services\CategoryServices;
use App\Services\SubCategoryServices;

class SubCategorySetting extends Controller
{   

    public function index()
    {
        $subcategories = SubCategoryServices::all();
        return view('admin.subcategory.subcategories_show',compact('subcategories'));
    }
    
    public function create()
    {
        $categories = CategoryServices::getAll(['name','id']);
        return view('admin.subcategory.create',compact('categories'));
    }

    public function save(SubCategoryValidator $request)
    {
        if(SubCategoryServices::store($request))
            return redirect()->back()->with('success','done');
        else
            return redirect()->back()->with('fail','sorry try again');

    }
 
    public function edite($subcategoryID)
    {
        $subcategory = SubCategoryServices::getByID($subcategoryID);
        $categories = CategoryServices::getAll(['name','id']);
        $subcategory->categoryName = SubCategoryServices::getParent($subcategory);
        return view('admin.subcategory.update',compact('subcategory','categories'));
    }

    public function update(SubCategoryValidator $request)
    {
        if(SubCategoryServices::update($request)){
            return redirect()->back()->with('success','done');
        }
            return redirect()->back()->with('fail','sorry try again');   
        
    }

    public function destroy($subcategoryID)
    {
        if(SubCategoryServices::destroy($subcategoryID))
            return redirect()->back()->with('success','done');
        else
            return redirect()->back()->with('fail','sorry try again');
    }

    public function getSubcategoryItems($subcategoryID)
    {
        $subcategory = SubCategoryServices::getByID($subcategoryID);
    
        $items = SubCategoryServices::getSubcategoriesItems($subcategory);

        $namespace = SubCategoryServices::getParent($subcategory);

        $subcategory = ['name'=>$subcategory->name,'namespace'=>$namespace];

        return view('admin.subcategory.show_items_of_subcategory',compact('items','subcategory'));
    }

}
