<?php

use App\Http\Controllers\Admin\AdminHome;
use App\Http\Controllers\Admin\AdsSetting;
use App\Http\Controllers\Admin\CategorySetting;
use App\Http\Controllers\Admin\DisplayErrorPage;
use App\Http\Controllers\Admin\ItemSetting;
use App\Http\Controllers\Admin\OrderSetting;
use App\Http\Controllers\Admin\ProfileSetting;
use App\Http\Controllers\Admin\SellerSetting;
use App\Http\Controllers\Admin\SubCategorySetting;
use App\Http\Controllers\AdminAuth\ForgotPasswordController;
use App\Http\Controllers\AdminAuth\LoginController;
use App\Http\Controllers\AdminAuth\LogoutController;
use App\Http\Controllers\AdminAuth\ResetPasswordController;
use App\Services\AdsServices;
use Illuminate\Support\Facades\Route;

define('PAGINATION',5);

route::get('admin/home',[AdminHome::class,'index'])->middleware('admin.auth')->name('admin.home');

route::prefix('admin/setting/')->middleware('auth:admin')->group(function(){

    route::controller(OrderSetting::class)->group(function(){

        route::get('/orders/show','getOrders')->name('orders.show');
        route::get('order-show/{orderId}','showOrder')->name('order.show');
        route::get('order-update/{orderId}','edite')->name('order.get.update');
        route::post('order-update','update')->name('order.update');
    
    });
    
    route::controller(CategorySetting::class)->group(function(){

        route::get('categories-show','index')->name('get.admin.categories');
        route::get('category-show/{categoryId}','showSubcategory')->name('category.show');
        
        route::get('category-update/{categoryId}','edite')->name('category.get.update');
        route::post('category-updates','update')->name('category.update');

        route::get('create/category','create')->name('category.create');
        route::post('save/category','save')->name('category.save');

        route::get('category/delete/{categoryID}','destroy')->name('category.delete');

    });
    
    route::controller(SubCategorySetting::class)->group(function(){

        route::get('subcategories-show','index')->name('get.admin.subcategories');

        route::get('subcategory-show/{subcategoryID}','getSubcategoryItems')->name('subcategory.show');

        route::get('subcategory-update/{subcategoryID}','edite')->name('subcategory.get.update');
        route::post('subcategory/update','update')->name('subcategory.update');

        route::get('create/subcategory','create')->name('subcategory.create');
        route::post('save/subcategory','save')->name('subcategory.save');

        route::get('delete/subcategory/{subCateID}','destroy')->name('subcategory.delete');

    });
    
    route::controller(ItemSetting::class)->group(function(){

        route::get('items-show','index')->name('get.admin.items');

        route::get('item-update/{itemID}','edite')->name('item.update');
        route::post('item-update','update')->name('item.save');

        route::get('create/item','create')->name('item.create.form');
        route::post('save/item','save')->name('item.create');

        route::get('item-delete/{itemID}','destroy')->name('item.delete');

    });

    route::controller(AdsSetting::class)->group(function(){

        route::get('create/ads','showItems')->name('create.ads');
        route::get('save/ads/{itemID}','save')->name('save.ads');
        route::get('show/ads','show')->name('show.ads');
        route::get('delete/ads/{itemID}','delete')->name('delete.ads');

    });
    route::get('tes',function(){
        return AdsServices::displayCandidate();
    });
    route::controller(SellerSetting::class)->group(function(){

        route::get('admin/get/seller/{type?}','index')->name('get.admin.seller');
        route::get('admin/active/seller/{sellerID}','activeSeller')->name('admin.active.seller');
        route::get('admin/delete/seller/{sellerID}','deleteSeller')->name('admin.delete.seller');

    });
    
    route::controller(ProfileSetting::class)->group(function(){

        route::get('admin/profile','index')->name('admin.profile');
        route::post('admin/profile/update','profileUpdate')->name('admin.update');
        
    });

});


Route::prefix('admin')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->middleware('guest:admin')->name('admin.login.form');
        Route::post('/login', 'login')->name('admin.login');
    });

    Route::get('/logout', [LogoutController::class,'logout'])->name('admin.logout');

    
    route::controller(ForgotPasswordController::class)->group(function(){

        Route::post('/password/email', 'sendResetLinkEmail')->name('admin.password.request');
        Route::get('/password/reset', 'showLinkRequestForm')->name('admin.password.reset');

    });
    
    route::controller(ResetPasswordController::class)->group(function(){

        Route::post('/password/reset', 'reset')->name('admin.password.email');
        Route::get('/password/reset/{token}/{email}','showResetForm')->name('admin.password.save');

    });
    
    route::get('error',[DisplayErrorPage::class,'displayErrorPage'])->name('admin.error');

});
