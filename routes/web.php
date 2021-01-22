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
    return view('home');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/deposit', function () {
    return view('deposit');
});

Route::get('/offer/create', function () {
    return view('offer.create');
});

Route::get('/discount/create', function () {
    return view('discount.create');
});

Route::get('/category/create', function () {
    return view('category.create');
});
