<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    return view('welcome');
});


// User Routes

  Route::get('home',[UserController::class,'home']);

  Route::get('product-detail/{id}',[UserController::class,'product_detail']);



Route::group(['middleware'=>['UserAuth2']],function(){

  Route::get('user-register',[UserController::class,'user_register']);
  Route::post('post-user-register',[UserController::class,'post_user_register']);

  Route::get('user-login',[UserController::class,'user_login']);
  Route::post('post-user-login',[UserController::class,'post_user_login']);

});

Route::get('add-cart-session/{id}',[UserController::class,'add_cart_session']);

Route::get('user-cart',[UserController::class,'user_cart']);

Route::get('remove-item/{id}',[UserController::class,'remove_item']);


Route::group(['middleware'=>['UserAuth']],function(){

    Route::get('user-logout',[UserController::class,'user_logout']);

    Route::get('add-cart/{id}',[UserController::class,'add_cart']);


    Route::get('stripe', [UserController::class, 'stripe']);

    Route::post('stripe', [UserController::class, 'stripePost'])->name('stripe.post');

    Route::get('my-order',[UserController::class,'my_order']);
    

});









// Machine Owner Routes

Route::get('owner-register',[OwnerController::class,'owner_register']);
Route::post('post-owner-register',[OwnerController::class,'post_owner_register']);

Route::get('owner-login',[OwnerController::class,'owner_login']);
Route::post('post-owner-login',[OwnerController::class,'post_owner_login']);


Route::group(['middleware'=>['OwnerAuth2']],function(){

  Route::get('owner-register',[OwnerController::class,'owner_register']);
  Route::post('post-owner-register',[OwnerController::class,'post_owner_register']);

  Route::get('owner-login',[OwnerController::class,'owner_login']);
  Route::post('post-owner-login',[OwnerController::class,'post_owner_login']);

});



Route::group(['middleware'=>['OwnerAuth']],function(){

  Route::get('owner-logout',[OwnerController::class,'owner_logout']);

  Route::get('owner-dashboard',[OwnerController::class,'owner_dashboard']);

  Route::get('products',[OwnerController::class,'products']);

  Route::get('add-product',[OwnerController::class,'add_product']);

  Route::post('post-add-product',[OwnerController::class,'post_add_product']);

  Route::get('delete-product/{id}',[OwnerController::class,'delete_product']);

  Route::post('update-product',[OwnerController::class,'update_product']);

});




// Admin Routes

Route::get('admin-login',[AdminController::class,'admin_login'])->middleware('AdminAuth2');

Route::post('post-admin-login',[AdminController::class,'post_admin_login'])->middleware('AdminAuth2');



Route::group(['middleware'=>['AdminAuth']],function(){

  Route::get('admin-dashboard',[AdminController::class,'admin_dashboard']);

  Route::get('admin-logout',[AdminController::class,'admin_logout']);

  Route::get('machine-owners',[AdminController::class,'machine_owners']);

  Route::get('users',[AdminController::class,'users']);

});