<?php

namespace App\Services;

use App\interfaces\StaticServicesContract;
use App\Models\SupCategory;
use App\Traits\RemoveImage;
use App\Traits\SaveImage;

class SubCategoryServices implements StaticServicesContract
{

    use SaveImage;
    use RemoveImage;
  
    public static function all()
    {
        $subcategories = SupCategory::paginate(PAGINATION);

        foreach($subcategories as $subcategory){

            $subcategory->itemNum = $subcategory->items()->count();;
            $subcategory->categoryName = $subcategory->category->name;

        }

        return $subcategories;
    }

    public static function store($request)
    {
        $category = CategoryServices::getByID($request->categoryID);

        if(SupCategory::where('category_id',$request->categoryID)->where('name',$request->subcategoryName)->exists()){
            return redirect()->back()->with('fail','sub-category exist');
        }

        $imageName = static::saveImage($request->image,'site\images\subcategories_image');

        return SupCategory::insert([
            'name'=>$request->subcategoryName,
            'category_id'=>$request->categoryID,
            'image'=>$imageName
        ]);
       
    }

    public static function update($request)
    {

        $category = CategoryServices::getByID($request->categoryID);;
        $subCate = SubCategoryServices::getByID($request->subcategoryID);

        if(isset($request->image)){

            static::RemoveImage('site/images/subcategories_image/'.$subCate->image);
            $imageName = static::saveImage($request->file('image'),'site/images/subcategories_image');
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

    public static function destroy($id)
    {

        $subcategory = SubCategoryServices::getByID($id);

        if($subcategory){

            if($subcategory->delete()){
                return static::RemoveImage("site/images/subcategories_image/".$subcategory->image);
            }
            return false;
        }
            
        return false;
    }

    public static function getByID($id,array $columns = null)
    {
        if($columns != null)
            return SupCategory::select($columns)->findorfail($id);
        return SupCategory::findorfail($id);
    }

    public static function getParent(SupCategory $subCate):string
    {
        return $subCate->category->name;
    }

    /**
     * return pagination items
     */
    public static function getSubcategoriesItems(SupCategory $subCate)
    {
        return $subCate->items()->paginate(PAGINATION);
    }

    public static function subCatgoryTopSellingItems($subCateId)
    {
        return ItemServices::getTopPicksItems($subCateId);
    }
    
    public static function getSupCategory($subCateID,&$categoryName):SupCategory
    {
        $subCategory = static::getByID($subCateID);
        if(! isset($subCategory))
            return abort('404');
       
        $subCategory->items =  static::getSubcategoriesItems($subCategory);
        
        foreach($subCategory->items as $item){
            $item = ItemServices::getItemDataToDisplay($item);
        }

        $categoryName = SubCategoryServices::getParent($subCategory);
        return $subCategory;

    }
}