<?php

namespace App\Services;

use App\Exceptions\FileNotFound;
use App\interfaces\StaticServicesContract;
use App\Models\Discount;
use App\Models\Items;
use App\Traits\CalculateNewPrice;
use App\Traits\RemoveImage;
use App\Traits\SaveImage;
use App\Traits\TopPicks;
use Exception;
use Illuminate\Support\Facades\DB;

class ItemServices implements StaticServicesContract{

    use SaveImage;
    use RemoveImage;
    use CalculateNewPrice;
    use TopPicks;

    public static function all()
    {
        $items = Items::paginate(PAGINATION);

        foreach($items as $item){

            $item->subcategoryName = ItemServices::getSubCategory($item,['name'])->name;

            $item->namespace = SubCategoryServices::getParent(
                SubCategoryServices::getByID($item->subcategory_id)
            );

        }
        return $items;
    }

    public static function getHasTopDiscount($itemNumber = null)//discount
    {
        if($itemNumber !== null)
            $topDeals = Discount::with('item')->select('discount_value','item_id')->
                        orderBy('discount_value','desc')->paginate($itemNumber);
        else
            $topDeals = Discount::with('item')->select('discount_value','item_id')->
                        orderBy('discount_value','desc')->get()->all();

        foreach($topDeals as $topDeal){

            $topDeal->item->categoryName = SubCategoryServices::getParent(
                SubCategoryServices::getByID($topDeal->item->subcategory_id)
            );

            $topDeal->item->newPrice = static::calcNewPrice($topDeal->discount_value,$topDeal->item->price);
        
        }
        return $topDeals;
    }

    public static function getHasTopDiscountBy($subCateID):Array
    {

        $topDeals = Items::with(['discount'=>function($q){
            $q->select('discount_value','item_id');
        }])->whereHas('discount')->where('subcategory_id',$subCateID)->get();

        foreach($topDeals as $topDeal){

            $topDeal->newPrice = static::calcNewPrice($topDeal->discount->discount_value,$topDeal->price);
        
        }
        return $topDeals->all();
    }

    public static function getFreeShippingNationalWide()
    {
        $items = Items::where('free_shipping',1)->paginate(6);

        foreach($items as $item){

            if($item->discount != null){
                $item->newPrice = static::calcNewPrice($item->discount->discount_value,$item->price);
            }

            $item->namespace = SubCategoryServices::getParent(
                SubCategoryServices::getByID($item->subcategory_id,['category_id'])
            );

        }

        return $items;
    }

    public static function itemExist($id)
    {
        return Items::where('id',$id)->exists();
    }

    /**
     * $data refer if you want discount and other data of item
     */
    public static function getByID($id, ?array $columns = null,$data = false)
    {
        if($columns !== null){
            $item = Items::select($columns)->findorfail($id);   
        }else{
            $item = Items::findorfail($id);
        }

        if($data ){

            $item->discount;

            $item->namespace = SubCategoryServices::getParent(
                SubCategoryServices::getByID($item->subcategory_id)
            );

            return $item;
        }

        return $item;
    }

    /**
     * item can be itemID or item object
     * get item discount,namespace,newprice
     */
    public static function getItemDataToDisplay($item)
    {
        if(is_numeric($item)){
            $item = Items::findorfail($item);
        }

        $item->discount = $item->discount()->select(['item_id','discount_value'])->first();
    
        $item->namespace = SubCategoryServices::getParent(
            SubCategoryServices::getByID($item->subcategory_id)
        );
    
        if($item->discount !== null)
            $item->newPrice = static::calcNewPrice($item->discount->discount_value,$item->price);

        return $item;
    }

    public static function getSubCategory(Items $item,array $columns = null)/////***** */
    {
        if($columns !== null)
            return $item->supCategory()->select($columns)->first();
        return $item->supCategory;
    }

    public static function getItemsOfEachSeller($items)
    {
        $itemsOfEachSeller = [];

        foreach($items as $item){

            $item_count = $item->pivot->item_count;
    
            $itemsOfEachSeller[$item->seller_id]['item'][] = $item->id; //store items id in array
    
            $itemsOfEachSeller[$item->seller_id]['count'][] = $item->pivot->item_count; //store items count in array
            
            if($item->discount!=null)
                ////store items price in array
                $itemsOfEachSeller[$item->seller_id]['price'][] =$item_count * static::calcNewPrice($item->discount->discount_value,$item->price);
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
    public static function allItemsWhere($column,$operator,$value,$getItemData=false)
    {
        $items = Items::where($column,$operator,$value)->paginate(PAGINATION);

        if($getItemData){

            foreach($items as $item){

                $item->namespace = SubCategoryServices::getParent(
                    SubCategoryServices::getByID($item->subcategory_id,['id','category_id'])
                );

                $item->discount;
                $item->subcategoryName = SubCategoryServices::getByID($item->subcategory_id,['name'])->name;
            }
            
        }

        return $items;
    }

    /**
     * if done return item count else return 0
     */
    public static function plusOne($itemID) :int
    {
        $item = ItemServices::getByID($itemID,['id','item_number']);
        $item->item_number ++;

        if($item->save())
            return $item->item_number;
        return 0;
    }

    public static function minusOne($itemID) :int
    {
        $item = ItemServices::getByID($itemID,['id','item_number']);
        $item->item_number --;

        if($item->save())
            return $item->item_number;
        return 0; 
    }
    
    public static function getItemDiscount(Items $item)
    {
        return $item->discount;
    }

    public static function countWhere($column,$operator,$value)
    {
        return Items::where($column,$operator,$value)->count();
    }

    /**
     * $existShipping mean explain if item create by seller or admin if seller will bass false 
     * because seller can not specify shipping state
     */
    public static function store($request , string $sellerID = '',$existShipping = true)
    {
        //$request->subcategory contain category id and subategory id like this 1 3 in string
        $subcategory_category_ids = explode(' ',$request->subcategory);
        
        $categoryName = CategoryServices::getByID($subcategory_category_ids[0],['name'])->name;

        $imageName = self::saveImage($request->image,'site/images/categories/'.$categoryName);   
        
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
    public static function edite($itemID)
    {
        $product = ItemServices::getByID($itemID,null,true);

        $product->subcategoryName = SubCategoryServices::getParent(
            SubCategoryServices::getByID($product->subcategory_id),['id','category_id']
        );

        return $product;
    }

    /**
     * get shops of seller and catgory and subcategory of this shops and return associative array
     */
    public static function create($sellerID)
    {   
        $shops = ShopServices::getBySellerID($sellerID,['category_id','name']);

        $shopAndcategoryAndSubcategories = [];
        
        foreach($shops as $shop){
            $shopAndcategoryAndSubcategories[$shop->name] = CategoryServices::getCategoryAndsubCates(
                'id','=',$shop->category_id
            );
        }

        return $shopAndcategoryAndSubcategories;
    }

    public static function update($request)
    {
        try{
            $imageName = static::saveImage($request->image,'site/images/categories/'.$request->categoryName.'/');
        
            $item = ItemServices::getByID($request->itemID);

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
    
            $path = 'C:/xampp/htdocs/onlinShop/public/site/images/categories/';
            $status = self::RemoveImage(
                $path.SubCategoryServices::getParent(SubCategoryServices::getByID($item->subcategory_id)).'/'.$oldImageName
            );

        }catch(Exception $obj){
            return $obj->getMessage();
        }
        
        return true;
    }

    public static function destroy($id)
    {

        $item = ItemServices::getByID($id);
        $path = 'C:/xampp/htdocs/onlinShop/public/site/images/categories/';

        try{
            self::RemoveImage(
                $path.SubCategoryServices::getParent(SubCategoryServices::getByID($item->subcategory_id)).'/'.$item->image
            );
        }catch(FileNotFound $obj){
            return $obj->getMessage();
        }

        return $item->delete();
        
    }

}