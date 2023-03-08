<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryValidator;
use App\Services\CategoryServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategorySetting extends Controller
{
    
    public function index()
    {
        $categories = CategoryServices::all();
        return view('admin.category.categories_show',compact('categories'));
    }


    public function showSubcategory($categoryID)
    {
        $subCategories = CategoryServices::getSubCategories($categoryID);
        return view('admin.category.subcategory_show',compact('subCategories'));
    }

    /*start update category*/

    public function edite($categoryID)
    {
        $category = CategoryServices::getByID($categoryID);
        return view('admin.category.edite',compact('category'));
    }

    public function update(Request $request)
    {
        $res = CategoryServices::update($request);
        
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
        $res = CategoryServices::store($request);
        return $this->redirectTo($res);
    }

    public function destroy($categoryID)
    {
        $status = CategoryServices::destroy($categoryID);
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
