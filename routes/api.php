<?php

use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\DeliveryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\TreeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
     
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('users', UsersController::class);
    Route::resource('products', ProductController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('stores', StoreController::class);
    // Route::resource('trees', TreeController::class);
    Route::get('/trees', [TreeController::class, 'index']);
    Route::get('/trees/{lead}', [TreeController::class, 'show']);

    // Deliveries Routes
    Route::resource('deliveries', DeliveryController::class);
    Route::patch('/deliveries/{id}/status', [DeliveryController::class, 'updateStatus']);
    Route::patch('/deliveries/{id}/payment-status', [DeliveryController::class, 'updatePaymentStatus']);
    Route::patch('/deliveries/{id}/assign-rider', [DeliveryController::class, 'assignRider']);
    Route::get('/deliveries/store/{storeId}', [DeliveryController::class, 'getByStore']);
    Route::get('/deliveries/rider/{riderId}', [DeliveryController::class, 'getByRider']);
});
