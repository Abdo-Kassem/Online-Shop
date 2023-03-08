<?php

namespace App\Traits;

use App\Events\SellerRegister;
use App\Http\Controllers\Site\Seller\CreateShopController;
use App\Http\Controllers\Site\SellerAuth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait CreateSellerSteps {

    use verifyEmail;

    public function createSteps(array $walletData)
    {
        DB::beginTransaction();

        $seller = (new RegisterController())->createSeller();

        if($seller !== null){

            (new CreateShopController())->createShop($seller->id);

            $this->createWallet($walletData,$seller->id);

            DB::commit();

            event(new SellerRegister($seller));

            session()->flush();

            Auth::guard('seller')->login($seller);

            return redirect()->route('seller.home');
        }
        DB::rollBack();
        return redirect()->route('seller.login');
    
    }

}