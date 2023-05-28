<?php

namespace App\Services;

use App\interfaces\ServicesContract;
use App\Models\Category;
use App\Models\Items;
use App\Traits\CalculateNewPrice;
use App\Traits\RemoveImage;
use App\Traits\SaveImage;
use App\Traits\TopPicks;
use Illuminate\Http\Request;

class CategoryServices implements ServicesContract{

    use SaveImage;
    use RemoveImage;
    use TopPicks;
    use CalculateNewPrice;

    private $subCate;

    public function __construct(SubCategoryServices $subCate)
    {
        $this->subCate = $subCate;
    }
    
    /**
     * return one category and its subcategory or null if not exist
     */
    public  function getCategoryAndsubCates($column,$operator,$value)
    {
        return Category::with('supCategories')->where($column,$operator,$value)->first();
    }

    public function getCategoriesAndChields()
    {
        return Category::with('supCategories')->get();
    }

    private  function getCategoriesDetails($categoryID,&$categoryName)
    {
        $category = static::getByID($categoryID,['id','name']);
        $subCategories = $category->supCategories;

        foreach($subCategories as $subCategory){

            $subCategory->items = $subCategory->items()->whereHas('discount')->get();

            if(count($subCategory->items)!=0){

                foreach( $subCategory->items as $item){
                    $item->newPrice = $this->calcNewPrice($item->discount->discount_value,$item->price);
                }

            }else{

                $subCategory->items = $subCategory->items()->paginate(10);
                
            }

        }

        $categoryName = $category->name;
        return $subCategories;
    }

    public function getTopSellingItems($cats) 
    {
        $count = $cats->count();

        if($count>0){

            $topSelling = [];
  
            foreach($cats as $cat){
                foreach($cat->supCategories as $subCategory){

                    $topSelling[$subCategory->name] = $this->subCate->subCatgoryTopSellingItems(
                        $subCategory->id
                    );
                    
                }
            } 
            
            return $topSelling;
        }

        return null;
        
    }

    public  function getCategory($categoryId , &$namespace)
    {
        $count = 0;  //to refer index of subCategories
        
        $subCategories = $this->getCategoriesDetails($categoryId,$namespace);

        foreach($subCategories as $subCategory){

            $subCategories[$count]->topPicks = $this->getTopPicksItems($subCategory->id);
            $count++;

        }

        return $subCategories;
    }

    /**
     * get all catagoery selected columns only not use pagination
     */
    public  function getAll(array $columns)
    {
        return Category::select($columns)->get();
    }

    /**
     * return catagory and subcategory number
     */
    public  function all()
    {
        $categories = Category::paginate(PAGINATION);
        foreach($categories as $cate){
            $cate->subNum = $cate->supCategories()->count();
        }
        return $categories;
    }

    public  function store($request)
    {
        $imageName = $this->saveImage($request->image,'site\images\categories_images');

        return Category::insert([
            'name'=>$request->categoryName,
            'selling_cost'=>$request->categorySellingCost,
            'image'=>$imageName
        ]);
    }

    public  function update($request)
    {
        $validatedData = self::validat($request);
        
        $category = Category::findorfail($request->categoryID);

        if(isset($request->image)){

            $oldImageName = $category->image;
            $imageName = $this->saveImage($request->image,'site\images\categories_images');

            $category->update([
                'name'=>$request->categoryName,
                'selling_cost'=>$request->categorySellingCost,
                'image' => $imageName
            ]);

            return $this->RemoveImage('site/images/categories_images/'.$oldImageName);
            
        }
        
        return $category->update([
            'name'=>$request->categoryName,
            'selling_cost'=>$request->categorySellingCost,
        ]);
    
    }

    public  function destroy($id)
    {
        $category = Category::findorfail($id);

        if($category){

            $this->RemoveImage('site/images/categories_images/'.$category->image);

            return $category->delete();
        }
        return false;
    }




    public function catgoryTopSellingItems($cateId)
    {
        $subCates = Category::findorfail($cateId)->supCategories;
        $topSellingItems = [];
        foreach($subCates as $subCate){
            $topSellingItems[] = $this->getTopPicksItems($subCate->id);
        }
        return $topSellingItems;
    }


    

    public function getCategoryTopDelas()
    {  
        //top deals = top selling
        $topDaals = [];
        $categoriseAndSubCates = Category::with(['supCategories'=>function($q){
            $q->select(['id','category_id']);
        }])->select(['id','name'])->get();

        foreach($categoriseAndSubCates as $categoryAndSubCate){

            $topDaals[$categoryAndSubCate->name] = [];

            foreach($categoryAndSubCate->supCategories as $subCate){
                $topDaals[$categoryAndSubCate->name] = array_merge(
                    $topDaals[$categoryAndSubCate->name],
                    (new ItemServices(new SubCategoryServices))->getHasTopDiscountBy($subCate->id)
                );
            }

        }
        return $topDaals;
       
    }

    /**
     * return columns category only
     */
    public function getByID($id,array $columns = null)//getCateByID
    {
        if($columns !== null)
            return Category::select($columns)->findorfail($id);
        return Category::findorfail($id);
    }

    private  function validat(Request $request)
    {
        return $request->validate(self::rules($request->categoryID),self::messages());
    }

    private  function rules($categoryID)
    {
        return [
            'categoryName'=>'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:categories,name,'.$categoryID,
            'categorySellingCost'=>'required'
        ];
    }

    private  function messages()
    {
        return [
            'categoryName.required'=>'name can not empty',
            'categoryName.regex'=>'name must be string',
            //'categoryName.unique'=>'category name must be not exist befor',
            'categorySellingCost.numeric'=>'cost required'
        ];
    }

}