<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProfileUpdateValidator;
use App\Models\Seller;
use App\Services\PhoneServices;
use App\Services\SellerServices;
use App\Services\ShopServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProfileSetting extends Controller
{

    private $seller ;
    private $phoneService ;
    private $sellerService;
    private $shopService;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->seller = Auth::guard('seller')->user();
            return $next($request);
        });

        $this->phoneService = new PhoneServices();
        $this->sellerService = new SellerServices;
        $this->shopService = new ShopServices;
    }

    
   public function index()
   {
        $this->sellerService->getProfileData($this->seller);
        return view('site.selling.seller_profile.profile_home')->with('seller',$this->seller);

   }

   public function editProfileInfo()
   {
        return view('site.selling.seller_profile.edit_info')->with('seller',$this->seller);
   }

   public function updateProfileInfo(SellerProfileUpdateValidator $request)
   {
        $status = $this->sellerService->update($request);

        if($status === true)
            return redirect()->route('seller.profile');
        elseif($status === false)
            return redirect()->back()->with('fail','sorry try again');
        else
            return redirect()->back()->with('fail','wrong password');

   }
    
   public function editPhone($id)
   {  
        $phone = $this->phoneService->getByIDWhere($id,'seller_id',$this->seller->id);
        return view('site.selling.seller_profile.change_phone_form',compact('phone'))->with('seller',$this->seller);
   }
   
   public function updatePhone(Request $request)
   {
        if($this->phoneService->updatePhone($request))
            return redirect()->route('seller.profile');

        return redirect()->back()->with('fail','update phone fail please try again');
   }

   public function destroy($phoneID)
   {
        if($this->phoneService->destroy($phoneID,$this->seller->id)){
            return redirect()->back()->with('success','done');
        }
        return redirect()->back()->with('fail','must have at least 2 phones');
   }

    public function deleteShop($shopID)
    {
        $status = $this->shopService->destroy($shopID,$this->seller->id);

        if($status === false)
            return redirect()->back()->with('fail','must has at least on shop');

        if($status > 0) 
            return redirect()->back()->with('success','deletion done');
        return redirect()->back()->with('fail','deletion fail try again');
    }

    public function editShop($shopID)
    {
        $seller = new Seller(['name'=>$this->seller->name,'image'=>$this->seller->image]);

        $shop = null; //will fill when send to getEditeData because send by reference

        $catgories = $this->shopService->getEditeData($this->seller->id,$shopID,$shop);
        
        $city = ['Cairo','Alexandria','Giza','bur saeid','Suez','The Red Sea','elbehera',
            'El Mansoura','Tanta','Asyut','Fayoum','Zagazig','Ismailia','Aswan','Damanhur',
            'El-Minya','Damietta','Luxor','Qena','Beni Suef','Sohag','Hurghada','outh of Sinaa',
            'Dakahlia','el-sharqia'
        ];

        return view('site.selling.seller_profile.edit_shop_form',compact('shop','catgories','city','seller'));
    
    }
    
    public function updateShop(Request $request,$shopID)
    {

        if($this->shopService->update($request,$shopID,$this->seller->id))
            return redirect()->route('seller.profile');
        return redirect()->back()->with('fail','edit fail try again');
    }
    
}
