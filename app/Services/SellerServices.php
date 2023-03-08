<?php

namespace App\Services;

use App\Exceptions\FileNotFound;
use App\interfaces\StaticServicesContract;
use App\Models\Phone;
use App\Models\Seller;
use App\Traits\CalculateNewPrice;
use App\Traits\CalculateSalesSumation;
use App\Traits\RemoveImage;
use App\Traits\SaveImage;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SellerServices implements StaticServicesContract{

    use CalculateNewPrice;
    use CalculateSalesSumation;
    use RemoveImage;
    use SaveImage;

    public static function all()
    {  
        return SellerServices::all();
    }

    public static function getProfileData(Seller &$seller)
    {
        $seller->phones = static::getPhones(
            $seller,['phone_number','is_wallet','wallet_approach','id']
        );

        $seller->shops = ShopServices::getBySellerID($seller->id);

        foreach($seller->shops as $shop){
            $shop->category_name = CategoryServices::getByID(
                $shop->category_id,['name']
            )->name;
        }

    }
    
    public static function getByID($id, ?array $columns = null)
    {
        if($columns !== null)
            return Seller::select($columns)->findorfail($id);
        return Seller::findorfail($id);
    }

    public static function getWhere($column , $operator , $value,array $columns = null):Collection
    {
        if($columns !== null)
            return Seller::where($column,$operator,$value)->select($columns)->get();
        return Seller::where($column,$operator,$value)->get();
    }

    public static function getAllByType(int $type=0)
    {

        if($type == 1){//get active seller
            $sellers = Seller::where('status',1)->paginate(PAGINATION);
        }elseif($type == 2){//get not active seller
            $sellers = Seller::where('status',0)->paginate(PAGINATION);
        }else{
            $sellers = Seller::paginate(PAGINATION);
        }

        if(is_null($sellers))
            return null;
        
        foreach($sellers as $seller){
            $seller->phones = $seller->phones()->select('phone_number','is_wallet','wallet_approach','id')->get();
            $seller->shops;
        }

        return $sellers;
    }

    public static function activeSeller($sellerID)
    {
        $seller = Seller::select(['id','status'])->findorfail($sellerID);
        return $seller->update(['status'=>1]);
    }

    public static function getLastSeller()
    {
        return Seller::with('phones')->orderBy('created_at','DESC')->first();
    }

    //get number of seller
    public static function getSellerNumber()
    {
        return  Seller::count();
    }

    public static function getSalesSum($sellerID)
    {
        $orders = OrderServices::getByStateAndWhere(1,'sellerID',$sellerID); //1 = compete
        return self::sellesSum($orders->items());//items() return returned items as array
    }

    public static function countCustomers(Seller $seller)
    {
        return $seller->customers()->count();
    }

    public static function getCustomer(Seller $seller,array $columns = null):LengthAwarePaginator
    {
        if($columns !== null)
            return $seller->customers()->select($columns)->paginate(PAGINATION);
        return $seller->customers()->paginate(PAGINATION);
    }

    public static function getPhones(Seller $seller,array $columns = null)
    {
        if($columns !== null)
            return $seller->phones()->select($columns)->get();
        return $seller->phones()->get();
    }

    //get number of disabled sellers
    public static function getDisabledSellerNumber()
    {
        return Seller::where('status',0)->count();
    }

    public static function analyzeWeek($sellerID)
    {

        $orders = OrderServices::analyzeWeek($sellerID);
        
        foreach($orders as $order){

            foreach($order->items as $item){

                $discount = ItemServices::getItemDiscount($item);

                if($discount !== null){
                    $item->discount_value = $discount->discount_value;
                    $item->newPrice = self::calcNewPrice($item->discount_value,$item->price);
                }
                
            }
            
            $order->orderOwner = OrderServices::getUserName($order);

        }

        return $orders;
        
    }

    /**
     * @param array $seller
     * 
     */
    public static function store($seller) 
    {
        $imagePath = $seller['image'][0];
        $imageName = $seller['image'][1];
        if(rename($imagePath.'/'.$imageName,'site/images/profile/'.$imageName)){

            $seller['image'] = $imageName;

            $phones = [
                ['phone_number'=>$seller['phone1'],'seller_id'=>$seller['id']],
                ['phone_number'=>$seller['phone2'],'seller_id'=>$seller['id']]
            ];

            unset($seller['phone1'],$seller['phone2']);

            try{
                DB::beginTransaction();
                Seller::insert($seller);
                $seller = SellerServices::getWhere('email','=',$seller['email'])->first() ;
                Phone::insert($phones);
                DB::commit();
                return $seller;
            }catch(Exception $obj){
                self::deleteTempFiles('site/images/temporary');
                return null; 
            }
        }
        return null;
    }

    private static function deleteTempFiles($path)
    { //delete temporary images

        if(! is_dir($path))
            abort(403,'not directory please pass valid path');

        $files = glob($path.'/'."*.{png,jpg,jpeg,gif}",GLOB_BRACE);

        foreach($files as $file){

            if(is_file($file))
                unlink($file);

        }
    }

    public static function update($request)
    {
        $seller = Auth::guard('seller')->user();
        $oldImageName = $seller->image;
        if(Hash::check($request->password,$seller->password)){

            $seller->name = $request->sellerName;
            $seller->id = $request->id;
            $seller->email = $request->email;
            $seller->acount_type = $request->acountType;
            
            if(isset($request->image))
                $seller->image = self::saveImage($request->image,'site/images/profile/');

            $res = $seller->save();
            
            if($res === true && isset($request->image)){
                
                return self::RemoveImage('site/images/profile/'.$oldImageName);
                
            }
            return $res;

        }else{

            return -1;
        }
    }
    
    public static function destroy($id)
    {
        
        $seller = Seller::findorfail($id);

        try{
            static::RemoveImage('site/images/profile/'.$seller->image);
        }catch(FileNotFound $obj){
            return $obj->getMessage();
        }

        return $seller->delete();

    }

}