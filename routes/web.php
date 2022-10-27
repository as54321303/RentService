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


Route::post('submit',[AdminController::class,'submit'])->name('submit');


// Admin Routes

Route::get('admin-login',[AdminController::class,'admin_login'])->middleware('AdminAuth2');

Route::post('post-admin-login',[AdminController::class,'post_admin_login'])->middleware('AdminAuth2');



Route::group(['middleware'=>['AdminAuth']],function(){

  Route::get('admin-dashboard',[AdminController::class,'admin_dashboard']);

  Route::get('admin-logout',[AdminController::class,'admin_logout']);

  Route::get('machine-owners',[AdminController::class,'machine_owners']);

  Route::get('users',[AdminController::class,'users']);

  Route::get('machine-category',[AdminController::class,'machine_category']);

  Route::get('machines',[AdminController::class,'machines']);

  Route::get('view-machine/{id}',[AdminController::class,'view_machine']);

});




