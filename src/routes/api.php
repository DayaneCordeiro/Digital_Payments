<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\WalletController;
use App\Http\Controllers\api\v1\TransactionController;

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

// Routes v1 group
Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('wallets', WalletController::class);
    Route::apiResource('transactions', TransactionController::class);

    Route::put('users_inactive', [UserController::class, 'inactive']);
    Route::put('users_active', [UserController::class, 'active']);

    Route::put('wallets_inactive', [WalletController::class, 'inactive']);
    Route::put('wallets_active', [WalletController::class, 'active']);
    Route::post('wallets_deposite', [WalletController::class, 'deposite']);

    Route::put('transactions_cancel', [TransactionController::class, 'cancel']);
    Route::put('transactions_cancel_by_user', [TransactionController::class, 'cancelByTimeTolerance']);
});
