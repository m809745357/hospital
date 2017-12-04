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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/introduce', 'HomeController@introduce')->name('introduce');
Route::get('/dynamics', 'DynamicController@index')->name('dynamic.index');
Route::get('/dynamics/{dynamic}', 'DynamicController@show')->name('dynamic.show');
Route::get('/specials', 'SpecialController@index')->name('special.index');
Route::get('/specials/{special}', 'SpecialController@show')->name('special.show');
Route::get('/schedulings', 'SchedulingController@index')->name('scheduling.index');
Route::get('/report', 'HomeController@report')->name('report');
Route::get('/contact', 'HomeController@contact')->name('contact');
