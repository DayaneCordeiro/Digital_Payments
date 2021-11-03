<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

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

Route::get('/store', function() {
    Redis::set('foo', 'bar');
});

Route::get('/retrieve', function() {
    return Redis::get('foo');
});

Route::get('/send-email', function() {
    Mail::to('dayane.cordeirogs@gmail.com')->send(new TestMail);
});

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
    Route::put('transactions_cancel_by_user', [TransactionController::class, 'cancelByUser']);
});