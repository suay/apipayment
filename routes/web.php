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


// Route::get('/', 'HomeController@index')->name('login');


// Auth::routes();
// Route::get('logout', 'Auth\LoginController@logout');

// Route::any('/user', 'UserController@index')->name('user');
// Route::get('/user/add', 'UserController@create')->name('add_user');
// Route::post('/user/view', 'UserController@view');

// //3d secured form show
// Route::any('/pay/form', 'payment\PaymentsController@responsepay');

Route::get('/', function () {
    return view('testpay');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/payment', 'payment\PaymentsController@index')->name('payment');

Route::any('/responsepage', 'payment\PaymentsController@responsepage')->name('responsepage');

Route::any('/responsepage2c2p', 'payment\PaymentsController@responsepage2c2p')->name('responsepage2c2p');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
// Route::any('/responsepage',[App\Http\Controllers\PaymentController::class, 'responsepage'])->name('responsepage');