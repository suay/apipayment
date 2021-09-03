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

Route::post('/charge', 'API\PaymentController@charge');
//=== call complete Charge ===//
Route::any('/playcomplete', 'API\PaymentController@callcomplete');

// chanel 2C2P
Route::post('/charge2c2p', 'API\PaymentController@charge2c2p');



// payment recurring only
Route::any('/responseback', 'API\PaymentController@responseback');

Route::post('/chargeforfree', 'API\PaymentController@forfree');

//payment normal
Route::any('/responsebackupgrades', 'API\PaymentController@responsebackupgrades');

//inquiry recurring
Route::any('/inquiry', 'API\PaymentController@inquiry');

//downgrade
Route::any('/downgrade', 'API\PaymentController@downgrade');

/*====================== manual =================================*/
//for manual create provisioning 
Route::post('/createmanual', 'API\PaymentController@createmanual');

// update expirce manual
Route::post('/updatemanual', 'API\PaymentController@updatemanual');

/*======================= check send email =================================*/
Route::any('/sendmail', 'API\PaymentController@cksendmail');

/*===================== response repay ========================*/
Route::post('/responsebackrepay', 'API\PaymentController@responsebackrepay');