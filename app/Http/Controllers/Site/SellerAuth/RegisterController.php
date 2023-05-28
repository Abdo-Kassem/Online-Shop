<?php

namespace App\Http\Controllers\Site\SellerAuth;


use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRegisterValidator;
use App\Services\SellerServices;
use App\Traits\SaveImage;
use Exception;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use SaveImage;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new sellers 
    |
    */

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:seller');
        
    }
    
    public function create()
    {
        return view('site.auth.seller_auth.register');
    }
    /**
     * save image in temporary directory and seller data in session
     * to save by registerProcessController by call createSeller
     */
    public function store(SellerRegisterValidator $request)
    {

        $validatedData = $request->except(['_token']);

        $imageName = $this->saveImage($validatedData['image'],'site/images/temporary');

        $validatedData['image'] = [ 'site/images/temporary',$imageName];
        
        unset($validatedData['reset_password'],$validatedData['reset_email']);

        $validatedData['password'] = Hash::make($validatedData['password']);
        
        session()->put('seller',$validatedData);
        
        return redirect()->route('seller.create.shop.form');

    }

    public function createSeller()
    {

        $seller = session()->get('seller'); //return array

        $res = (new SellerServices)->store($seller);

        return $res;

    }
  
}
