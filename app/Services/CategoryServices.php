<?php

namespace App\Services;

use App\interfaces\StaticServicesContract;
use App\Models\Category;
use App\Models\Items;
use App\Traits\RemoveImage;
use App\Traits\SaveImage;
use Illuminate\Http\Request;

class CategoryServices implements StaticServicesContract{

    use SaveImage;
    use RemoveImage;
   
    public static function getSubCategories($categoryID)
    {
        $category = Category::findorfail($categoryID);

        $subCategories = $category->supCategories()->paginate(PAGINATION);

        foreach($subCategories as $subCategory){
            $subCategory->itemNum = Items::where('subcategory_id',$subCategory->id)->count();
        }  
        
        return $subCategories;
    }

    /**
     * return one category and its subcategory or null if not exist
     */
    public static function getCategoryAndsubCates($column,$operator,$value)
    {
        return Category::with('supCategories')->where($column,$operator,$value)->first();
    }

    public static function getCategoriesAndChields()
    {
        return Category::with('supCategories')->get();
    }

    private static function getCategoriesDetails($categoryID,&$categoryName)
    {
        $category = static::getByID($categoryID,['id','name']);
        $subCategories = $category->supCategories;

        foreach($subCategories as $subCategory){

            $subCategory->items = $subCategory->items()->whereHas('discount')->get();

            if(count($subCategory->items)!=0){

                foreach( $subCategory->items as $item){
                    $item->newPrice = ItemServices::calcNewPrice($item->discount->discount_value,$item->price);
                }

            }else{

                $subCategory->items = $subCategory->items()->paginate(10);
                
            }

        }

        $categoryName = $category->name;
        return $subCategories;
    }

    public static function getCategory($categoryId , &$namespace)
    {
        $count = 0;  //to refer index of subCategories
        
        $subCategories = static::getCategoriesDetails($categoryId,$namespace);

        foreach($subCategories as $subCategory){
            $subCategories[$count]->topPicks = ItemServices::getTopPicksItems($subCategory->id);
            $count++;
        }

        return $subCategories;
    }

    /**
     * get all catagoery selected columns only not use pagination
     */
    public static function getAll(array $columns)
    {
        return Category::select($columns)->get();
    }

    /**
     * return catagory and subcategory number
     */
    public static function all()
    {
        $categories = Category::paginate(PAGINATION);
        foreach($categories as $cate){
            $cate->subNum = $cate->supCategories()->count();
        }
        return $categories;
    }

    public static function store($request)
    {
        $imageName = static::saveImage($request->image,'site\images\categories_images');

        return Category::insert([
            'name'=>$request->categoryName,
            'selling_cost'=>$request->categorySellingCost,
            'image'=>$imageName
        ]);
    }

    public static function update($request)
    {
        $validatedData = self::validat($request);
        
        $category = Category::findorfail($request->categoryID);

        if(isset($request->image)){

            $oldImageName = $category->image;
            $imageName = static::saveImage($request->image,'site\images\categories_images');

            $category->update([
                'name'=>$request->categoryName,
                'selling_cost'=>$request->categorySellingCost,
                'image' => $imageName
            ]);

            return static::RemoveImage('site/images/categories_images/'.$oldImageName);
            
        }
        
        return $category->update([
            'name'=>$request->categoryName,
            'selling_cost'=>$request->categorySellingCost,
        ]);
    
    }

    public static function destroy($id)
    {
        $category = Category::findorfail($id);

        if($category){

            static::RemoveImage('site/images/categories_images/'.$category->image);

            return $category->delete();
        }
        return false;
    }

    public static function catgoryTopSellingItems($cateId)
    {
        $subCates = Category::findorfail($cateId)->supCategories;
        $topSellingItems = [];
        foreach($subCates as $subCate){
            $topSellingItems[]=ItemServices::getTopPicksItems($subCate->id);
        }
        return $topSellingItems;
    }

    public static function getCategoryTopDelas()
    {  //top deals = top selling
        $topDaals = [];
        $categoriseAndSubCates = Category::with(['supCategories'=>function($q){
            $q->select(['id','category_id']);
        }])->select(['id','name'])->get();

        foreach($categoriseAndSubCates as $categoryAndSubCate){
            $topDaals[$categoryAndSubCate->name] = [];
            foreach($categoryAndSubCate->supCategories as $subCate){
                $topDaals[$categoryAndSubCate->name] = array_merge($topDaals[$categoryAndSubCate->name],ItemServices::getHasTopDiscountBy($subCate->id));
            }
        }
        return $topDaals;
        return view('site.topDealsAll',compact('topDeals'));
    }

    /**
     * return columns category only
     */
    public static function getByID($id,array $columns = null)//getCateByID
    {
        if($columns !== null)
            return Category::select($columns)->findorfail($id);
        return Category::findorfail($id);
    }

    public static function validat(Request $request)
    {
        return $request->validate(self::rules($request->categoryID),self::messages());
    }

    private static function rules($categoryID)
    {
        return [
            'categoryName'=>'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:categories,name,'.$categoryID,
            'categorySellingCost'=>'required'
        ];
    }

    private static function messages()
    {
        return [
            'categoryName.required'=>'name can not empty',
            'categoryName.regex'=>'name must be string',
            //'categoryName.unique'=>'category name must be not exist befor',
            'categorySellingCost.numeric'=>'cost required'
        ];
    }

}