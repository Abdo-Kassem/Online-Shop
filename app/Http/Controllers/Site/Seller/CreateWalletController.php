<?php

namespace App\Http\Controllers\Site\Seller;


use App\Http\Controllers\Controller;
use App\Http\Requests\WalletValidator;
use App\Models\Phone;
use App\Traits\CreateSellerSteps;

class CreateWalletController extends Controller
{
    /*
    | create wallet 
    |
    */
    use CreateSellerSteps;


    public function __construct()
    {
        
        
    }
    
    public function store(WalletValidator $request)
    {
        return $this->createSteps($request->except('_token'));
    }
    
    public function createWallet($data,$sellerID):bool
    {
        $phone = Phone::where('phone_number',$data['phone_number'])->first();

        if($phone && isset($data['wallet_approach'])){
            
            $phone->update(['is_wallet'=>1,'wallet_approach'=>$data['wallet_approach']]);
            return true;

        }else if(isset($data['wallet_approach'])){
            $phone = Phone::insert([
                'phone_number'=>$data['phone_number'],
                'is_wallet'=>'1',
                'seller_id'=>$sellerID,
                'wallet_approach'=>$data['wallet_approach']
            ]);
            if($phone){
                return true;
            } else{
                return false;
            }
        }else{
           return true;
        }
    }
    
   
    public function create()
    {
        return view('site.auth.seller_auth.send_mony_approach_form');
    }

}
