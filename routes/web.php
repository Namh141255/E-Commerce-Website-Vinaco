<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\ProductController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('App\Http\Controllers\Front')->group(function () {
    Route::get('/', [IndexController::class,'index']);

    //Listing/Categories Routes
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url');
    foreach ($catUrls as $key => $url) {
        Route::get($url, 'ProductController@listing');
    }

    //Product Details Page
    Route::get('product/{id}', 'ProductController@detail');

    //Get Product Attribute Price
    Route::post('get-attribute-price','ProductController@getAttributePrice');

    //Add to Cart
    Route::post('/add-to-cart','ProductController@addToCart');

    //Shopping Cart
    Route::get('cart', 'ProductController@cart');

    //Update Cart Item Qty
    Route::post('update-cart-item-qty','ProductController@updateCartItemQty');

    //Delete Cart Item
    Route::post('delete-cart-item','ProductController@deleteCartItem');

    //Empty Cart
    Route::post('empty-cart','ProductController@emptyCart');

    //User Login
    Route::match(['get','post'],'user/login','UserController@loginUser')->name('login');

    Route::group(['middleware'=>['auth']],function(){
        //User Logout
        Route::get('user/logout','UserController@logoutUser');

        //User Account
        Route::match(['get','post'],'user/account','UserController@account');

        //Checkout
        Route::match(['get','post'],'checkout','ProductController@checkout');
    });
    
    //User Register
    Route::match(['get','post'],'user/register','UserController@registerUser');
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    
    Route::match(['get','post'],'login','AdminController@login');
    Route::group(['middleware'=> ['admin']], function () {
        Route::get('dashboard',[AdminController::class,'dashboard']);
        Route::match(['get','post'],'update-password',[AdminController::class,'updatePassword']);
        Route::match(['get','post'],'update-details',[AdminController::class,'updateDetails']);
        Route::post('check-current-password',[AdminController::class,'checkCurrentPassword']);
        Route::get('logout',[AdminController::class,'logout']);

        //Display CMS Page (CRUD-READ)
        Route::get('cms-pages',[CmsController::class,'index']);
        Route::post('update-cms-page-status',[CmsController::class,'update']);
        Route::match(['get','post'],'add-edit-cms-page/{id?}',[CmsController::class,'edit']);
        Route::get('delete-cms-page/{id?}',[CmsController::class,'destroy']);

        //Subadmins
        Route::get('subadmins',[AdminController::class,'subadmins']);
        Route::post('update-subadmin-status',[AdminController::class,'updateSubadminStatus']);
        Route::match(['get','post'],'add-edit-subadmin/{id?}',[AdminController::class,'addEditSubadmin']);
        Route::get('delete-subadmin/{id?}',[AdminController::class,'deleteSubadmin']);
        Route::match(['get','post'],'update-role/{id}',[AdminController::class,'updateRole']);

        //Categories
        Route::get('categories',[CategoryController::class,'categories']);
        Route::post('update-category-status',[CategoryController::class,'updateCategoryStatus']);
        Route::match(['get','post'],'add-edit-category/{id?}',[CategoryController::class,'addEditCategory']);
        Route::get('delete-category/{id?}',[CategoryController::class,'deleteCategory']);
        Route::get('delete-category-image/{id?}',[CategoryController::class,'deleteCategoryImage']);

        //Products
        Route::get('products',[ProductsController::class,'products']);
        Route::post('update-product-status',[ProductsController::class,'updateProductStatus']);
        Route::get('delete-product/{id?}',[ProductsController::class,'deleteProduct']);
        Route::match(['get','post'],'add-edit-product/{id?}',[ProductsController::class,'addEditProduct']);

        //Product Images
        Route::get('delete-product-image/{id?}',[ProductsController::class,'deleteProductImage']);

        //Product Videos
        Route::get('delete-product-video/{id?}',[ProductsController::class,'deleteProductVideo']);

        //Product Attributes
        Route::post('update-attribute-status',[ProductsController::class,'updateAttributeStatus']);
        Route::get('delete-attribute/{id?}',[ProductsController::class,'deleteAttribute']);

        //Banner
        Route::get('banners',[BannersController::class,'banners']);
        Route::post('update-banner-status',[BannersController::class,'updateBannerStatus']);
        Route::get('delete-banner/{id?}',[BannersController::class,'deleteBanner']);
        Route::match(['get','post'],'add-edit-banner/{id?}',[BannersController::class,'addEditBanner']);
    });
        
});