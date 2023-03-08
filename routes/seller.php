<?php

use App\Http\Controllers\Site\Auth\SellerAuth\ForgotPasswordController;
use App\Http\Controllers\Site\Seller\AnalyzeWeek;
use App\Http\Controllers\Site\Seller\CreateShopController;
use App\Http\Controllers\Site\Seller\CreateWalletController;
use App\Http\Controllers\Site\Seller\CustomerManage;
use App\Http\Controllers\Site\Seller\OrderSetting;
use App\Http\Controllers\Site\Seller\ProductSetting;
use App\Http\Controllers\Site\SellerAuth\LoginController;
use App\Http\Controllers\Site\SellerAuth\RegisterController;
use App\Http\Controllers\Site\SellerAuth\ResetPasswordController;
use App\Http\Controllers\Site\Seller\SellerExpenses;
use App\Http\Controllers\Site\Seller\SellerHome;
use App\Http\Controllers\Site\Seller\SellerProfileSetting;
use App\Http\Controllers\Site\Seller\SellerShipping;
use App\Http\Controllers\Site\Seller\Selling;
use App\Http\Controllers\Site\Seller\ShopManage;
use App\Http\Controllers\Site\Seller\TestController;
use App\Http\Controllers\Site\Seller\TestVerification;
use App\Http\Controllers\Site\Seller\VerificationNotice;
use App\Http\Controllers\Site\SellerAuth\EmailVerification;
use App\Http\Controllers\Site\SellerAuth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('seller')->group(function () {

    route::controller(LoginController::class)->group(function(){

        Route::get('/login', 'showLoginForm')->name('seller.login.form');
        Route::post('/login', 'login')->name('seller.login');

    });
  
    Route::post('/logout', [LogoutController::class,'logout'])->name('seller.logout');

    route::controller(RegisterController::class)->group(function(){

        Route::get('/register/seller', 'create')->name('seller.register.form');
        Route::post('/register/seller', 'store')->name('seller.register');

    });

    route::controller(CreateShopController::class)->group(function(){
        Route::get('/create/shop', 'create')
            ->middleware('seller.check.previus.state')->name('seller.create.shop.form');
        Route::post('/create/shop', 'store')->name('seller.create.shop');
    });

    route::controller(CreateWalletController::class)->group(function(){
        Route::get('/create/wallet', 'create')
            ->middleware('seller.check.previus.state')->name('seller.create.wallet.form');
        Route::post('/create/wallet', 'store')->name('seller.create.wallet');
    });
    
    route::get('/verify/{token}',[EmailVerification::class,'verifyEmail'])->name('email.verify');
    
    route::get('/verification/notice',[VerificationNotice::class,'notice'])->name('verification.notice');
    
    route::controller(ForgotPasswordController::class)->group(function(){
        
        Route::post('/password/email', 'sendResetLinkEmail')->name('password.request');
        Route::get('/password/reset', 'showLinkRequestForm');
    
    });
    
    route::controller(ResetPasswordController::class)->group(function(){

        Route::post('/password/reset', 'reset')->name('password.email');
        Route::get('/password/reset/{token}', 'showResetForm');

    });

});

route::prefix('seller')->controller(Selling::class)->group(function(){
      //create first shop
      route::get('/create-first-shop','registerShopForm')->name('seller.create_first_shop');
      route::post('/save-first-shop','createShop')->name('seller.save_first_shop');

      route::get('/create_wallet','registerWalletForm')->name('seller.create_wallet');
      route::post('/save_wallet','createWallet')->name('seller.save_wallet');

});

route::prefix('seller')->middleware('seller.auth:seller')->group(function(){  

    Route::get('/home', [SellerHome::class,'index'])->middleware('verified')->name('seller.home');

    route::prefix('/profile')->controller(SellerProfileSetting::class)->group(function(){

        route::get('/','index')->name('seller.profile');

        route::get('/edit','editProfileInfo')->name('seller.edit');
        route::post('/update','updateProfileInfo')->name('seller.update');
    
    
        route::get('/delete/shop/{shopID}','deleteShop')->name('shop.delete');
        route::get('/edit/shop/{shopID}','editShop')->name('shop.edit');
        route::post('/update/shop/{shopID}','updateShop')->name('shop.update');

        route::get('/edit/phone/{phoneID}','editPhone')->name('phone.edit');
        route::post('/update/phone','updatePhone')->name('phone.update');
        route::get('/delete/phone/{phoneID}','destroy')->name('phone.delete');
        
    });

    route::get('/shipping',[SellerShipping::class,'index'])->name('seller.shipping');
    route::get('/selling-expenses',[SellerExpenses::class,'index'])->name('seller.selling-expenses');

    route::controller(OrderSetting::class)->group(function(){
        route::get('/show/orders','showOrders')->name('seller.show.orders');
        route::get('/order/show/{orderID}','itemOfOrder')->name('seller.order.show');
    });

    route::controller(ProductSetting::class)->group(function(){

        route::prefix('product/')->group(function(){
            
            route::get('edit/{productID}','edite')->name('ptoduct.edit');
            route::post('update','update')->name('ptoduct.update');
    
            route::get('destroy/{productID}','productDestroy')->name('ptoduct.destroy');
    
            route::get('plus/{productID}','productPlusOne')->name('ptoduct.plus');
            route::get('minus/{productID}','productMinusOne')->name('ptoduct.minus');
        
            route::get('create','create')->name('product.create');
            route::post('create','store')->name('product.save');
    
        });

        route::get('/show/products','getProducts')->name('seller.show.product');

    });
    
    route::controller(AnalyzeWeek::class)->group(function(){
        route::get('analyze','analyzeYourWeek')->name('seller.analyze');
    });

    route::controller(ShopManage::class)->group(function(){
        route::get('/create-shop','create')->name('seller.create_shop');
        route::post('/save-shop','store')->name('seller.save_shop');
    });

    route::controller(CustomerManage::class)->group(function()
    {
        route::get('/customer','getCustomer')->name('seller.customer');
        route::get('/customer/feedback','getCustomerFeedback')->name('seller.customer.feedback');
        
        //will remove customer(user) from specific seller
       
        route::get('/customer/remove/{customerID}','removeCustomer')->name('seller.customer.remove');

    });
    
});
