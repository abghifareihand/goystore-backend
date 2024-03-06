<?php

use App\Http\Controllers\API\CallbackController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // get user
    Route::get('user', [UserController::class, 'fetch']);
    // update user
    Route::post('user', [UserController::class, 'updateProfile']);
    // upload photo
    Route::post('user/photo', [UserController::class, 'updatePhoto']);
    // logout user
    Route::post('logout', [UserController::class, 'logout']);

    // get transaction
    Route::get('transactions', [TransactionController::class, 'all']);
    // checkout
    Route::post('checkout', [TransactionController::class, 'checkout']);
});

// get product and category
Route::get('products', [ProductController::class, 'all']);
Route::get('categories', [ProductCategoryController::class, 'all']);

// register and login user
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// callback midtrans
Route::post('midtrans/callback', [CallbackController::class, 'callback']);
