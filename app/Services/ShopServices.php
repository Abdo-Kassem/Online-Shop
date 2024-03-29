<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Shop;

class ShopServices {

   
    /**
     * if send empty array this mean that will us session to save shop
     */
    public function store($sellerID,array $shop):bool
    {
        if(count($shop)>0){
            $shop['sellerID'] = $sellerID;
            return Shop::insert($shop);
        }
        $shop = session()->get('shop');
        $shop['sellerID'] = $sellerID;
        return Shop::insert($shop);
    }

    public function create($sellerID)
    {
        
        $sellerCatyegoryShops = Shop::select('category_id')->where('sellerID',$sellerID)->get();
        
        $endfor = $sellerCatyegoryShops->count();

        $catgories = Category::select((['name','id']))->get();(['name','id']);

        foreach($catgories as $catgoryKey=>$catgoryValue){

            for($count=0;$count<$endfor;$count++){

                if($sellerCatyegoryShops[$count]->category_id === $catgoryValue->id)
                    $catgories->forget($catgoryKey);
                    
            }
        }

        return $catgories;
    }

    public function getEditeData($sellerID,$shopID,&$shop)
    {
        $shop = Shop::where('sellerID',$sellerID)->findorfail($shopID);

        $sellerCategories = Shop::where('id','!=',$shopID)->select('category_id')->get();

        $categories = Category::select((['name','id']))->get();(['name','id']);

        $categoryCount = $categories->count();

        foreach($sellerCategories as $sellerCategory){

            for($count=0;$count<$categoryCount;$count++){

                if($categories[0]->id === $sellerCategory->category_id){
                   $categories->forget($count);
                   break;
                }

            }

        }
        return $categories;
    }

    public function update($request,$shopID,$sellerID)
    {
        
        $request->validate(self::rules($request->shopID),self::messages());
 
        $shop = Shop::where('sellerID',$sellerID)->findorfail($shopID);

        $shop->name = $request->shopName;
        $shop->address = $request->shopAddress;
        $shop->post_number = $request->postNumber;
        $shop->sended_person_email = $request->email;
        $shop->category_id = $request->productType;
        $shop->city = $request->city;

        return $shop->save();

    }

    private function rules($shopID){
        return [//like this assiut-manflout-25 mohamed street
            'shopName'=>'required|string|unique:shops,name,'.$shopID,
            'shopAddress'=>'required|regex:/^([A-Za-z]{4,11})(\,[A-Za-z]+)*(\s[0-9]+)*(\s[A-Za-z]+)+$/',
            'postNumber'=>'required|digits_between:5,5',
            'email'=>'required|email',
        ];
    }
    private function messages(){
        return [
            'shopName.required'=>'you must enter shop name',
            'shopName.string'=>'must be string',
            'shopAddress.required'=>'must enter address',
            'shopAddress.regex'=>'please enter valide address',
            'postNumber.required'=>'must enter postNumber',
            'postNumber.digits_between'=>'must be five digits',
            'email.required'=>'must enter emails',
            'email.email'=>'must be email'
        ];
    }

    public function destroy($shopID,$sellerID)
    {
        $shops = Shop::where('sellerID',$sellerID)->count();

        if($shops > 1){
            $shop = Shop::where('sellerID',$sellerID)->findorfail($shopID);
            return $shop->delete();
        }

        return false;
        
    }

}
