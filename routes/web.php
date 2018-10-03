<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth','two_factor');
Route::get('/otp_form', 'OTPController@showForm')->middleware('auth');
Route::get('/otp_resend',[
    'as' => 'otp_resend',
    'uses' => 'OTPController@reSend'
]
)->middleware('auth');

Route::post('/otp_submit', [
    'as' => 'otp_submit',
    'uses' => 'OTPController@validateOTP'
]);




