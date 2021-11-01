<?php

use Illuminate\Support\Facades\Route;

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
