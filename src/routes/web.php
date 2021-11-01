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