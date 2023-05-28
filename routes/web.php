<?php

use App\Http\Controllers\Site\Auth\Login;
use App\Http\Controllers\Site\Auth\Logout;
use App\Http\Controllers\Site\Auth\Register;
use App\Http\Controllers\Site\Auth\Email_Verification;
use App\Http\Controllers\Site\BasketSetting;
use App\Http\Controllers\Site\FeedbackManager;
use App\Http\Controllers\Site\GetCategories;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\Order;
use App\Http\Controllers\Site\savedItemsManager;
use App\Http\Controllers\Site\Search;
use App\Http\Controllers\Site\Seller\Selling;
use App\Http\Controllers\Site\ShowItem;
use App\Http\Controllers\Site\SubCategory;
use App\Http\Controllers\Site\UserAcount;
use App\Http\Controllers\Testing\Test;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*start home page routes*/
route::controller(HomeController::class)->group(function(){
    route::get('/home', 'index')->name('home');
    route::get('/', 'index')->name('home');
});

route::controller(UserAcount::class)->group(function(){

    route::get('user/acount','index')->name('user.acount');
    route::get('user/edite','edite')->name('user.edite');
    route::post('user/update','update')->name('user.update');

});

route::get('item_details/{item_id}',[ShowItem::class,'index'])->name('item.details');

route::controller(Order::class)->group(function(){

    route::get('user/createOrder','createOrder')->name('create.order');
    route::get('user/orders','index')->name('user.orders');

    route::get('user/order/cancel/{orderID}','cancel')->name('order.cancel');

});



route::controller(BasketSetting::class)->middleware('auth:web')->group(function(){

    route::get('user/carts','getBasket')->name('user.cart');
    route::get('add-to-cart/{itemId}','addToBasket')->name('item.add-to-cart');
    route::get('delete-cart/{itemId}','delete')->name('item.delete-from-cart');
    route::get('increase/{itemID}','plus')->name('item.increase-cart');
    route::get('decrease/{itemId}','minus')->name('item.decrease-cart');

});

route::post('user/add/addfeedback',[FeedbackManager::class,'setFeedback'])->name('customer.addfeedback');

route::controller(savedItemsManager::class)->group(function(){

    route::get('item/save/{itemId}','addToSavedItems')->name('item.save.toList');
    route::get('getSavedItems','getSavedItems')->name('saved-items');
    route::get('delete-from-savedItems/{item_id}','removeSavedItems')->name('item.delete-from-savedItems');

});

route::get('start-now',[Selling::class,'startNow'])->name('selling');//->middleware('seller.guest');

route::post('search',[Search::class,'search'])->name('search');

route::prefix('categories')->group(function(){
    route::get('get/category/{cateID}',[GetCategories::class,'getCategory'])->name('get.category');
    route::get('sub-category/get/{subcateID}',[SubCategory::class,'getSupCategory'])->name('category.subCategory');
    route::get('getTopPicks/{subCateName}/{id}',[SubCategory::class,'getTopPicksItems'])->name('topPicks.subCategory');
    route::get('item-top-deals',[GetCategories::class,'getCategoryTopDelas'])->name('item.top.deals');
});

/*start custom auth*/

route::controller(Login::class)->group(function(){
    route::get('login','getForm')->name('login');
    route::post('user-login','login')->name('user-login');
});

route::controller(Register::class)->group(function(){
    route::get('register','getForm')->name('register')->middleware('guest:web');
    route::post('register','register')->name('register');
});

route::get('verify/{token}',[Email_Verification::class,'verifyEmail'])->name('user.email.verify');

route::get('logout',[Logout::class,'logout'])->name('user.logout');
route::get('tests',[Test::class,'main']);
require __DIR__ . '/admin.php';
require __DIR__ . '/seller.php';