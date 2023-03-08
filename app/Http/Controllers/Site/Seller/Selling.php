<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopValidator;
use App\Http\Requests\WalletValidator;
use App\Models\Category;
use App\Models\Phone;
use App\Models\Shop;
use App\Traits\SaveImage;
use Illuminate\Support\Facades\Auth;

class Selling extends Controller
{
    use SaveImage;
    public function __construct()
    {
       /* return $this->middleware('seller:seller')->only(
            ['registerShopForm','registerWalletForm']
        );*/
    }
    
    public function startNow()
    {
        return view('site.selling.selling_start_now');
    }
    
    public function registerShopForm(){
        $catgories = Category::select('name','id')->get();
        $city = ['Cairo','Alexandria','Giza','bur saeid','Suez','The Red Sea','elbehera',
            'El Mansoura','Tanta','Asyut','Fayoum','Zagazig','Ismailia','Aswan','Damanhur',
            'El-Minya','Damietta','Luxor','Qena','Beni Suef','Sohag','Hurghada','outh of Sinaa',
            'Dakahlia','el-sharqia'
        ];
        return view('site.auth.seller_auth.create_shop',compact('catgories','city')); 
    }
    public function registerWalletForm(){
        return view('site.auth.seller_auth.send_mony_approach_form');
    }
    
    public function createShop(ShopValidator $request){
        $shopState = Shop::insert([
            'name'=>$request->shopName,
            'address'=>$request->shopAddress,
            'post_number'=>$request->postNumber,
            'city'=>$request->city,
            'category_name'=>$request->productType,//will storwe category name
            'sended_person_email'=>$request->email,
            'created_at'=>now(),
            'sellerID'=>Auth::guard('seller')->user()->id
        ]);
        if($shopState){
            return redirect()->route('seller.home');
        }else{
            return redirect()->back()->with('fail','sorry try again');
        }
    }
    public function createWallet(WalletValidator $request){
        $res = Phone::where('phone_number',$request->phone)->first();
        if($res){
            $res->update(['is_wallet'=>1,'wallet_approach'=>$request->walletType]);
        }else{
            $phone = Phone::insert([
                'phone_number'=>$request->phone,
                'is_wallet'=>'1',
                'seller_id'=>Auth::guard('seller')->user()->id,
                'wallet_approach'=>$request->walletType
            ]);
            if($phone){
                return redirect()->route('seller.home');
            } else
                return redirect()->back()->with('fail','please try again');
        }
    }
    
}
