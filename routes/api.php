<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OwnerController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Owner Routes

Route::post('owner-login',[OwnerController::class,'owner_login']);
Route::post('owner-register',[OwnerController::class,'owner_register']);


Route::middleware(['auth:sanctum','abilities:owner'])->group(function(){

    Route::post('owner/add-machine',[OwnerController::class,'add_machine']);

    Route::post('owner/my-machines',[OwnerController::class,'my_machines']);

    Route::post('owner-logout',[OwnerController::class,'owner_logout'])->middleware(['auth:sanctum','abilities:owner']);

    Route::post('owner-details',[OwnerController::class,'owner_details'])->middleware(['auth:sanctum','abilities:owner']);

});


// User Routes

Route::post('user-login',[UserController::class,'user_login']);
Route::post('user-register',[UserController::class,'user_register']);

Route::get('machines',[UserController::class,'machines']);
Route::get('add-to-cart/{id}',[UserController::class,'add_to_cart']);

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('user-logout',[UserController::class,'user_logout']);
    Route::post('user-details',[UserController::class,'user_details']);
    
});
Route::get('categories',[UserController::class,'categories']);
Route::post('find-by-category',[UserController::class,'find_by_category']);


