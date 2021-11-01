<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// User Routes
Route::get('user/{id}', 'UserController@getUser');
Route::post('user', 'UserController@createUser');
Route::delete('user/{id}', 'UserController@deleteUser');

// Transaction Routes
Route::get('transaction/{id}', 'TransactionController@getTransaction');
Route::put('transaction/{id}', 'TransactionController@updateTransaction');
Route::post('transaction', 'TransactionController@createTransaction');
Route::delete('Transaction/{id}', 'TransactionController@deleteTransaction');

// Wallet Routes
Route::get('wallet/{id}', 'WalletController@getWallet');
Route::put('wallet/{id}', 'WalletController@updateWallet');
Route::post('wallet', 'WalletController@createWallet');
Route::delete('wallet/{id}', 'WalletController@deleteWallet');
