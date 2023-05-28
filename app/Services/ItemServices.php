<?php

namespace App\Services;

use App\Exceptions\FileNotFound;
use App\interfaces\ServicesContract;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Items;
use App\Models\Shop;
use App\Models\SupCategory;
use App\Traits\CalculateNewPrice;
use App\Traits\RemoveImage;
use App\Traits\SaveImage;
use App\Traits\TopPicks;
use Exception;
use Illuminate\Support\Facades\DB;

class ItemServices implements ServicesContract{

    use SaveImage;
    use RemoveImage;
    use CalculateNewPrice;
    use TopPicks;

    private  $subCategory;

    public function __construct(SubCategoryServices $subCategory)
    {
        $this->subCategory = $subCategory;
    }

    public  function all()
    {
        $items = Items::paginate(PAGINATION);

        foreach($items as $item){

            $item->subcategoryName = $this->getSubCategory($item,['name'])->name;

            $this->getNamespace($item);

        }
        return $items;
    }

    public function getHasTopDiscount($itemNumber = null)//discount
    {
        if($itemNumber !== null)
            $topDeals = Discount::with('item')->select('discount_value','item_id')->
                        orderBy('discount_value','desc')->paginate($itemNumber);
        else
            $topDeals = Discount::with('item')->select('discount_value','item_id')->
                        orderBy('discount_value','desc')->get()->all();

        foreach($topDeals as $topDeal){
           
            $topDeal->item->categoryName =
            SupCategory::select('id','name','category_id')->findorfail($topDeal->item->subcategory_id)->category->name;

            $topDeal->item->newPrice = $this->calcNewPrice($topDeal->discount_value,$topDeal->item->price);
        
        }

        return $topDeals;

    }

    public  function getHasTopDiscountBy($subCateID):Array
    {

        $topDeals = Items::with(['discount'=>function($q){
            $q->select('discount_value','item_id');
        }])->whereHas('discount')->where('subcategory_id',$subCateID)->get();

        foreach($topDeals as $topDeal){

            $topDeal->newPrice = $this->calcNewPrice($topDeal->discount->discount_value,$topDeal->price);
        
        }
        
        return $topDeals->all();
    }

    public  function getFreeShippingNationalWide()
    {
        $items = Items::where('free_shipping',1)->paginate(6);

        foreach($items as $item){

            if($item->discount != null){
                $item->newPrice = $this->calcNewPrice($item->discount->discount_value,$item->price);
            }

            $this->getNamespace($item);

        }

        return $items;
    }

    /**
     * $data refer if you want discount and other data of item
     */
    public  function getByID($id, array $columns = null,$data = false)
    {
        if($columns !== null){
            $item = Items::select($columns)->findorfail($id);   
        }else{
            $item = Items::findorfail($id);
        }

        if($data ){

            $item->discount;

            $this->getNamespace($item);

            return $item;
        }

        return $item;
    }

    /**
     * item can be itemID or item object
     * get item discount,namespace,newprice
     */
    public  function getItemDataToDisplay($item)
    {
        if(is_numeric($item)){
            $item = Items::findorfail($item);
        }

        $item->discount = $item->discount()->select(['item_id','discount_value'])->first();
    
        $this->getNamespace($item);
    
        if($item->discount !== null)
            $item->newPrice = $this->calcNewPrice($item->discount->discount_value,$item->price);

        return $item;
    }

    public function getSubCategory(Items $item,array $columns = null)/////***** */
    {
        if($columns !== null)
            return $item->supCategory()->select($columns)->first();
        return $item->supCategory;
    }

    public  function getItemsOfEachSeller($items)
    {
        $itemsOfEachSeller = [];

        foreach($items as $item){

            $item_count = $item->pivot->item_count;
    
            $itemsOfEachSeller[$item->seller_id]['item'][] = $item->id; //store items id in array
    
            $itemsOfEachSeller[$item->seller_id]['count'][] = $item->pivot->item_count; //store items count in array
            
            if($item->discount!=null)
                ////store items price in array
                $itemsOfEachSeller[$item->seller_id]['price'][] =$item_count * $this->calcNewPrice($item->discount->discount_value,$item->price);
            else{
                //store items price in array
                $itemsOfEachSeller[$item->seller_id]['price'][] =$item_count * $item->price;
            }
    
          }
          return $itemsOfEachSeller;
    }

    /**
     * getItemData refer to if you want namespace and discount and subcategoryName of item by default false
     * use paginate
     */
    public  function allItemsWhere($column,$operator,$value,$getItemData=false)
    {
        $items = Items::where($column,$operator,$value)->paginate(PAGINATION);

        if($getItemData){

            foreach($items as $item){

                $this->getNamespace($item);

                $item->discount;
                $item->subcategoryName = $this->subCategory->getByID($item->subcategory_id,['name'])->name;
            }
            
        }

        return $items;
    }

    /**
     * if done return item count else return 0
     */
    public  function plusOne($itemID) :int
    {
        $item = $this->getByID($itemID,['id','item_number']);
        $item->item_number ++;

        if($item->save())
            return $item->item_number;
        return 0;
    }

    public  function minusOne($itemID) :int
    {
        $item = $this->getByID($itemID,['id','item_number']);
        
        if($item->item_number > 0)
            $item->item_number --;
        else
            return 0;

        if($item->save())
            return $item->item_number;
        return false; 
    }


    /**
     * get shops of seller and catgory and subcategory of this shops and return associative array
     */
    public  function create($sellerID)
    {   
        $shops = Shop::select(['category_id','name'])->where('sellerID',$sellerID)->get();

        $shopAndcategoryAndSubcategories = [];
        
        foreach($shops as $shop){

            $shopAndcategoryAndSubcategories[$shop->name] = Category::findorfail($shop->category_id);
           
        }

        return $shopAndcategoryAndSubcategories;
    }


    /**
     * $existShipping mean explain if item create by seller or admin if seller will bass false 
     * because seller can not specify shipping state
     */
    public  function store($request , string $sellerID = '',$existShipping = true)
    {
        //$request->subcategory contain category id and subategory id like this 1 3 in string
        $subcategory_category_ids = explode(' ',$request->subcategory);
        
        $categoryName = Category::select('name')->findorfail($subcategory_category_ids[0])->name;

        $imageName = $this->saveImage($request->image,'site/images/categories/'.$categoryName);   
        
        $data = $request->except(['_token','subcategory','image']);
        $data['subcategory'] = $subcategory_category_ids[1];
        $data['imageName'] = $imageName;

        if($sellerID !== '')
            $data['sellerID'] = $sellerID;
            
        if(!$existShipping){
            $data['shipping'] = 1;
            $data['shipping_cost'] = 0;
        }
        
        try{

            DB::beginTransaction();

            $item = Items::create([
                'name'=>$data['itemName'],
                'details'=>$data['details'],
                'price'=>$data['price'],
                'subcategory_id'=>$data['subcategory'],
                'free_shipping'=>$data['shipping'],
                'image'=>$data['imageName'],
                'seller_id'=>$data['sellerID'],
                'shipping_cost' => $data['shipping_cost']
            ]);
            if($item&&isset($data['discount'])){
                Discount::insert([
                    'discount_value'=>$data['discount'],
                    'time_start'=>$data['start_time'],
                    'time_end'=>$data['end_time'],
                    'item_id'=>$item->id
                ]);
            }
            DB::commit();
            return true;
        }catch(Exception $ex){
           return false;
        }
       
    }

    /**
     * get item and discount,namespace and subcategory name
     */
    public  function edite($itemID)
    {
        $product = $this->getByID($itemID,null,true);

        return $product;
    }

    
    public  function update($request)
    {
        try{
            $imageName = $this->saveImage($request->image,'site/images/categories/'.$request->categoryName.'/');
        
            $item = $this->getByID($request->itemID);

            $oldImageName = $item->image;
            
            $data = $request->except(['_token','image']);
            $data['image'] = $imageName;

            if(!isset($data['shipping'])){
                $data['shipping'] = 1;  //shipping free
                $data['shipping_cost'] = 0; //shipping cost 0
            }

            DB::beginTransaction();
            
            $res = $item->update([
                'name'=>$data['itemName'],'details'=>$data['details'],'image'=>$data['image'],
                'price'=>$data['price'],'free_shipping'=>$data['shipping'],'shipping_cost'=>$data['shipping_cost']
            ]);

            if(isset($data['discount'])){
                $res = Discount::updateOrCreate(['item_id'=>$item->id],
                    [
                        'discount_value'=>$data['discount'],'time_start' => $data['time_start'],
                        'time_end' => $data['time_end']
                    ]
                );
            }

            DB::commit();

            $this->getNamespace($item);
    
            $path = 'C:/xampp/htdocs/onlinShop/public/site/images/categories/';
            $status = $this->RemoveImage(
                $path.$item->namespace.'/'.$oldImageName
            );

        }catch(Exception $obj){
            throw $obj;
            return $obj->getMessage();
        }
        
        return true;
    }

    public  function destroy($id)
    {

        $item = $this->getByID($id);
        $this->getNamespace($item);

        $path = 'C:/xampp/htdocs/onlinShop/public/site/images/categories/';

        try{

            $this->RemoveImage(
                $path.$item->namespace.'/'.$item->image
            );

        }catch(FileNotFound $obj){
            return $obj->getMessage();
        }

        return $item->delete();
        
    }

    private function getNamespace(&$item)
    {
        $item->namespace = Category::select(['name'])->findorfail(
            SupCategory::select('category_id')->findorfail($item->subcategory_id)->category_id
        )->name;
    }

}