<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryValidator;
use App\Models\Category;
use App\Services\CategoryServices;
use App\Services\SubCategoryServices;

class SubCategorySetting extends Controller
{   

    private $subCate;

    public function __construct(SubCategoryServices $subCate)
    {
        $this->subCate = $subCate;
    }


    public function index()
    {
        $subcategories = $this->subCate->all();
        return view('admin.subcategory.subcategories_show',compact('subcategories'));
    }
    
    public function create()
    {
        $categories = Category::select(['id','name'])->get();
        return view('admin.subcategory.create',compact('categories'));
    }

    public function save(SubCategoryValidator $request)
    {
        if($this->subCate->store($request))
            return redirect()->back()->with('success','done');
        else
            return redirect()->back()->with('fail','sorry try again');

    }
 
    public function edite($subcategoryID)
    {
        $subcategory = $this->subCate->getByID($subcategoryID);
        $categories = Category::select(['id','name'])->get();;
        $subcategory->categoryName = $subcategory->category->name;
        return view('admin.subcategory.update',compact('subcategory','categories'));
    }

    public function update(SubCategoryValidator $request)
    {
        if($this->subCate->update($request)){
            return redirect()->back()->with('success','done');
        }
            return redirect()->back()->with('fail','sorry try again');   
        
    }

    public function destroy($subcategoryID)
    {
        if($this->subCate->destroy($subcategoryID))
            return redirect()->back()->with('success','done');
        else
            return redirect()->back()->with('fail','sorry try again');
    }

    public function getSubcategoryItems($subcategoryID)
    {
        $subcategory = $this->subCate->getByID($subcategoryID);
    
        $items = $this->subCate->getSubcategoriesItems($subcategory);

        $namespace = $subcategory->category->name;;

        $subcategory = ['name'=>$subcategory->name,'namespace'=>$namespace];

        return view('admin.subcategory.show_items_of_subcategory',compact('items','subcategory'));
    }

}
