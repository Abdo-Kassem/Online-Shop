<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopValidator;
use App\Services\ShopServices;
use Illuminate\Support\Facades\Auth;

class ShopManage extends Controller
{
    /**
     * manage shop operation 
     */

     private $sellerID , $shop;

     public function __construct(ShopServices $shop)
     {
        $this->middleware(function ($request, $next) {
            $this->sellerID = Auth::guard('seller')->id();
            return $next($request);
        });

        $this->shop = $shop;

     }


    public function create()
    {
        $catgories = $this->shop->create($this->sellerID);

        $city = ['Cairo','Alexandria','Giza','bur saeid','Suez','The Red Sea','elbehera',
            'El Mansoura','Tanta','Asyut','Fayoum','Zagazig','Ismailia','Aswan','Damanhur',
            'El-Minya','Damietta','Luxor','Qena','Beni Suef','Sohag','Hurghada','outh of Sinaa',
            'Dakahlia','el-sharqia'
        ];

        return view('site.selling.shop.create',compact('catgories','city')); 
    }

    public function store(ShopValidator $request)
    {

        $shop = [
            'name'=>$request->name,
            'address'=>$request->address,
            'post_number'=>$request->post_number,
            'city'=>$request->city,
            'category_id'=>$request->productType,//will store category id
            'sended_person_email'=>$request->sended_person_email,
            'created_at'=>now(),
        ];
        
        if($this->shop->store($this->sellerID,$shop)){
            return redirect()->back()->with('success','done');
        }else{
            return redirect()->back()->with('fail','sorry try again');
        }
        
    }
    
}
