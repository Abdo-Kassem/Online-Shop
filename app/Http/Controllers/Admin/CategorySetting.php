<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryValidator;
use App\Services\CategoryServices;
use App\Services\SubCategoryServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategorySetting extends Controller
{
    private $category,$subCate;

    public function __construct(CategoryServices $category,SubCategoryServices $subCate)
    {
        $this->category = $category;
        $this->subCate = $subCate;
    }

    public function index()
    {
        $categories = $this->category->all();
        return view('admin.category.categories_show',compact('categories'));
    }


    public function showSubcategory($categoryID)
    {
        $subCategories = $this->subCate->getSubCategoriesByCatID($categoryID);
        return view('admin.category.subcategory_show',compact('subCategories'));
    }

    /*start update category*/

    public function edite($categoryID)
    {
        $category = $this->category->getByID($categoryID);
        return view('admin.category.edite',compact('category'));
    }

    public function update(Request $request)
    {
        $res = $this->category->update($request);
        
        if($res){
            return redirect()->route('get.admin.categories')->with('success','done');
        }else{
            return redirect()->back()->with('fail','sorry try again');
        }
        
    }

    
    /*end update category*/

    public function create()
    {
        return view('admin.category.create');
    }

    public function save(Request $request)
    {
        $res = $this->category->store($request);
        return $this->redirectTo($res);
    }

    public function destroy($categoryID)
    {
        $status = $this->category->destroy($categoryID);
        return $this->redirectTo($status);
    }
    
    private function redirectTo($status):RedirectResponse
    {
        if($status)
            return redirect()->back()->with('success','done');
        else
            return redirect()->back()->with('fail','sorry try again');
    }

}
