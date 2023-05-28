<?php

namespace App\Http\Controllers\Site\Seller;


use App\Http\Controllers\Controller;
use App\Http\Requests\ShopValidator;
use App\Models\Category;
use App\Services\CategoryServices;
use App\Services\ShopServices;

class CreateShopController extends Controller
{
    
    private $shop;

    public function __construct(ShopServices $shop)
    {
        $this->shop = $shop;
    }

    /**
     * store shop data in session
     */
    public function store(ShopValidator $request)
    {
        $shop = $request->except(['_token']);
        session()->put('shop',$shop);
        return redirect()->route('seller.create.wallet.form');
    }

    /**
     * create shop from session by default if not send columns data
     * 
     */
    public function createShop($sellerID,array $columns = [])
    {
        return $this->shop->store($sellerID,$columns);
    }

    public function create()
    {
        $catgories = Category::select((['name','id']))->get();(['name','id']);

        $city = ['Cairo','Alexandria','Giza','bur saeid','Suez','The Red Sea','elbehera',
            'El Mansoura','Tanta','Asyut','Fayoum','Zagazig','Ismailia','Aswan','Damanhur',
            'El-Minya','Damietta','Luxor','Qena','Beni Suef','Sohag','Hurghada','outh of Sinaa',
            'Dakahlia','el-sharqia'
        ];
        
        return view('site.auth.seller_auth.create_shop',compact('catgories','city')); 
    }

}
