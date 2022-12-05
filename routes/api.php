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

Route::get('get',function(){
    return "Ayush";
});

Route::prefix('owner')->group(function(){

    Route::post('login',[OwnerController::class,'login']);
    Route::post('google-login',[OwnerController::class,'googleLogin']);
    Route::post('signup',[OwnerController::class,'signUp']);
    Route::post('forgot-password',[OwnerController::class,'forgotPassword']);
    Route::post('verify-otp',[OwnerController::class,'verifyOtp']);
    Route::get('city',[OwnerController::class,'city']);


            Route::middleware(['auth:sanctum','abilities:owner'])->group(function(){

                Route::post('change-password',[OwnerController::class,'changePassword']);

                Route::post('add-machine',[OwnerController::class,'addMachine']);

                Route::get('my-machines',[OwnerController::class,'myMachines']);
                Route::post('machine-details',[OwnerController::class,'machineDetails']);

                Route::post('logout',[OwnerController::class,'logout']);

                Route::get('details',[OwnerController::class,'ownerDetails']);
                Route::post('on-service-machines',[OwnerController::class,'onServiceMachines']);
                Route::post('rent-period-completed',[OwnerController::class,'rentPeriodCompleted']);

                Route::post('search-machines',[OwnerController::class,'searchMachines']);

                Route::get('requested-machine',[OwnerController::class,'requestedMachine']);

            });



});




// User Routes

            Route::prefix('user')->group(function(){


                Route::post('user-login',[UserController::class,'user_login']);
                Route::post('user-signup',[UserController::class,'signUp']);
                Route::post('forgot-password',[UserController::class,'forgotPassword']);
                Route::post('verify-otp',[UserController::class,'verifyOtp']);
                Route::get('machines',[UserController::class,'machines']);
                Route::post('reset-password',[UserController::class,'resetPassword']);

                Route::get('new-machines',[UserController::class,'newMachines']);
                Route::post('search-machines',[UserController::class,'searchMachines']);

                Route::post('filter-machine',[UserController::class,'filterMachine']);

                Route::middleware(['auth:sanctum'])->group(function(){

                    Route::get('user-logout',[UserController::class,'user_logout']);
                    Route::get('user-details',[UserController::class,'user_details']);
                    Route::post('change-password',[UserController::class,'change_password']);
                    // Route::post('machine-request',[UserController::class,'machine_request']);
                    Route::post('calculate-price',[UserController::class,'calculatePrice']);
                    Route::post('take-on-rent',[UserController::class,'takeOnRent']);
                    Route::get('on-rent',[UserController::class,'onRent']);
                    Route::get('completed-rent-period',[UserController::class,'completedRentPeriod']);
                    Route::post('complaint',[UserController::class,'complaint']);
                    Route::post('delete-account',[UserController::class,'deleteAccount']);

                });
                Route::get('machine-categories',[UserController::class,'categories']);
                Route::post('find-by-category',[UserController::class,'find_by_category']);

            });




