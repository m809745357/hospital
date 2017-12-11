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
    return redirect()->route('home');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/introduce', 'HomeController@introduce')->name('introduce');
Route::get('/dynamics', 'DynamicController@index')->name('dynamic.index');
Route::get('/dynamics/{dynamic}', 'DynamicController@show')->name('dynamic.show');
Route::get('/specials', 'SpecialController@index')->name('special.index');
Route::get('/specials/{special}', 'SpecialController@show')->name('special.show');
Route::get('/schedulings', 'SchedulingController@index')->name('scheduling.index');
Route::get('/report', 'HomeController@report')->name('report');
Route::get('/contact', 'HomeController@contact')->name('contact');

Route::get('/user', 'UserController@index')->name('user.index');
Route::post('/user', 'UserController@update')->name('user.update');
Route::post('/sms', 'MobileController@store')->name('sms.store');
Route::post('/sms/{mobile}', 'MobileController@update')->name('sms.update');

Route::get('/parcels', 'ParcelController@index')->name('parcel.index');
Route::post('/orders', 'OrderController@store')->name('order.store');
Route::get('/orders/{order}', 'OrderController@show')->name('order.show');
Route::post('/orders/{order}/card', 'OrderController@card')->name('order.card');
