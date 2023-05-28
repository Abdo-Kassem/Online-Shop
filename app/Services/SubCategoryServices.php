<?php

namespace App\Services;

use App\interfaces\ServicesContract;
use App\Models\Category;
use App\Models\Items;
use App\Models\SupCategory;
use App\Traits\RemoveImage;
use App\Traits\SaveImage;
use App\Traits\TopPicks;

class SubCategoryServices implements ServicesContract
{

    use SaveImage;
    use RemoveImage;
    use TopPicks;
  
    public  function all()
    {
        $subcategories = SupCategory::paginate(PAGINATION);

        foreach($subcategories as $subcategory){

            $subcategory->itemNum = $subcategory->items()->count();;
            $subcategory->categoryName = $subcategory->category->name;

        }

        return $subcategories;
    }

    public function getByID($id)
    {
        return SupCategory::findorfail($id);
    }

    public function getSubCategoriesByCatID($catID) 
    {
        $subCategories = SupCategory::where('id',$catID)->paginate(PAGINATION);

        foreach($subCategories as $subCategory){
            $subCategory->itemNum = Items::where('subcategory_id',$subCategory->id)->count();
        }  
        
        return $subCategories;
    }
    
    public  function store($request)
    {
        $category = Category::findorfail($request->categoryID);

        if(SupCategory::where('category_id',$request->categoryID)->where('name',$request->subcategoryName)->exists()){
            return redirect()->back()->with('fail','sub-category exist');
        }

        $imageName = $this->saveImage($request->image,'site\images\subcategories_image');

        return SupCategory::insert([
            'name'=>$request->subcategoryName,
            'category_id'=>$request->categoryID,
            'image'=>$imageName
        ]);
       
    }

    public function update($request)
    {

        $category = Category::findorfail($request->categoryID);
        $subCate = SupCategory::finorfail($request->subcategoryID);

        if(isset($request->image)){

            $this->RemoveImage('site/images/subcategories_image/'.$subCate->image);
            $imageName = $this->saveImage($request->file('image'),'site/images/subcategories_image');
            return $subCate->update([
                'name'=>$request->subcategoryName,
                'category_id'=>$request->categoryID,
                'image'=>$imageName
            ]);

        }
        else
            return $subCate->update([
                'name'=>$request->subcategoryName,
                'category_id'=>$request->categoryID,
            ]);

    }

    public  function destroy($id)
    {

        $subcategory = SupCategory::findorfail($id);

        if($subcategory){

            if($subcategory->delete()){
                return $this->RemoveImage("site/images/subcategories_image/".$subcategory->image);
            }
            return true;
        }
            
        return false;
    }

    /**
     * return pagination items
     */
    public  function getSubcategoriesItems(SupCategory $subCate)
    {
        return $subCate->items()->paginate(PAGINATION);
    }

    public  function subCatgoryTopSellingItems($subCateId)
    {
        return $this->getTopPicksItems($subCateId);
    }
    
    public function getSupCategory($subCateID,&$categoryName):SupCategory
    {
        $subCategory = $this->getByID($subCateID);

        if(! isset($subCategory))
            return abort('404');
       
        $subCategory->items =  $this->getSubcategoriesItems($subCategory);
        
        foreach($subCategory->items as $item){
            $item = (new ItemServices(new SubCategoryServices))->getItemDataToDisplay($item);
        }

        $categoryName = $subCategory->category->name;
        return $subCategory;

    }
}