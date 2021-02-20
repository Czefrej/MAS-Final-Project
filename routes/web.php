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

Route::resource('category', \App\Http\Controllers\CategoryController::class)->middleware("auth")->middleware("auth.admin");

Route::resource('offer', \App\Http\Controllers\OfferController::class)->middleware("auth")->middleware("auth.admin");

Route::resource('discount', \App\Http\Controllers\DiscountController::class)->middleware("auth")->middleware("auth.admin");

Route::resource('transaction', \App\Http\Controllers\TransactionController::class)->middleware("auth")->middleware("auth.admin");


Route::get('/', function () {
    return view('home');
});

Route::get('/deposit', '\App\Http\Controllers\DepositController@index')->name('deposit.index')->middleware("auth");
Route::post('/deposit', '\App\Http\Controllers\DepositController@store')->name('deposit.store')->middleware("auth");

Route::get('/product/{category_id?}', '\App\Http\Controllers\ProductController@index');

Route::get('/buy/{id}', '\App\Http\Controllers\BuyController@purchase')->middleware("auth");

Route::get('/register', '\App\Http\Controllers\Auth\AuthController@register')->name('register');
Route::post('/register', '\App\Http\Controllers\Auth\AuthController@storeUser');

Route::get('/login', '\App\Http\Controllers\Auth\AuthController@login')->name('login');
Route::post('/login', '\App\Http\Controllers\Auth\AuthController@authenticate');
Route::get('logout', '\App\Http\Controllers\Auth\AuthController@logout')->name('logout');

Route::get('/', '\App\Http\Controllers\Auth\AuthController@home')->name('home');
