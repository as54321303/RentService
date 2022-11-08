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


Route::prefix('owner')->group(function(){


    Route::post('login',[OwnerController::class,'login']);
    Route::post('google-login',[OwnerController::class,'googleLogin']);
    Route::post('register',[OwnerController::class,'register']);


            Route::middleware(['auth:sanctum','abilities:owner'])->group(function(){

                Route::post('add-machine',[OwnerController::class,'addMachine']);

                Route::post('my-machines',[OwnerController::class,'myMachines']);

                Route::post('logout',[OwnerController::class,'logout']);

                Route::post('details',[OwnerController::class,'ownerDetails']);
                Route::post('on-service-machines',[OwnerController::class,'onServiceMachines']);
                Route::post('search-machines',[OwnerController::class,'searchMachines']);

                Route::get('requested-machine',[OwnerController::class,'requestedMachine']);

            });



});




// User Routes

Route::prefix('user')->group(function(){


    Route::post('user-login',[UserController::class,'user_login']);
    Route::post('user-register',[UserController::class,'user_register']);
    Route::post('verify-otp',[UserController::class,'verifyOtp']);


    Route::get('new-machines',[UserController::class,'newMachines']);
    Route::post('search-machines',[UserController::class,'searchMachines']);

    Route::post('filter-machine',[UserController::class,'filter_machine']);

    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('user-logout',[UserController::class,'user_logout']);
        Route::get('user-details',[UserController::class,'user_details']);
        Route::post('change-password',[UserController::class,'change_password']);
        Route::post('machine-request',[UserController::class,'machine_request']);
        Route::post('calculate-price',[UserController::class,'calculatePrice']);
        Route::post('take-on-rent',[UserController::class,'takeOnRent']);
        Route::get('on-rent',[UserController::class,'onRent']);
        Route::get('completed-rent-period',[UserController::class,'completedRentPeriod']);
        Route::get('complain',[UserController::class,'complain']);
    });
    Route::get('categories',[UserController::class,'categories']);
    Route::post('find-by-category',[UserController::class,'find_by_category']);

});




