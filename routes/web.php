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
Route::get('/oauth_callback', 'Auth\LoginController@oauthCallback')->name('callback');
Route::get('/introduce', 'HomeController@introduce')->name('introduce');
Route::get('/dynamics', 'DynamicController@index')->name('dynamic.index');
Route::get('/dynamics/{dynamic}', 'DynamicController@show')->name('dynamic.show');
Route::get('/specials', 'SpecialController@index')->name('special.index');
Route::get('/specials/{special}', 'SpecialController@show')->name('special.show');
Route::get('/schedulings', 'SchedulingController@index')->name('scheduling.index');
Route::get('/report', 'HomeController@report')->name('report');
Route::get('/contact', 'HomeController@contact')->name('contact');

Route::get('/user/bind', 'UserController@bind')->name('user.bind');
Route::post('/user', 'UserController@update')->name('user.update');
Route::any('/payment/wechat/notify', 'OrderController@notify')->name('order.notify');
Route::post('/sms', 'MobileController@store')->name('sms.store');
Route::post('/sms/{mobile}', 'MobileController@update')->name('sms.update');

Route::get('/ipads/{ipad}/parcels', 'ParcelController@index')->name('ipads.parcel.index');
Route::post('/ipads/{ipad}/orders', 'OrderController@store')->name('ipads.order.store');
Route::get('/ipads/{ipad}/orders/{order}', 'OrderController@show')->name('ipads.order.show');
Route::post('/ipads/{ipad}/orders/{order}/ipad', 'OrderController@ipad')->name('order.ipad');
Route::post('/upload', 'HomeController@upload')->name('upload.file');

Route::group(['middleware' => 'prefect'], function () {
    Route::get('/user', 'UserController@index')->name('user.index');
    Route::get('/user/room', 'UserController@room')->name('user.room');

    Route::get('/parcels', 'ParcelController@index')->name('parcel.index')->middleware(['address', 'auth']);
    Route::post('/orders', 'OrderController@store')->name('order.store')->middleware(['auth']);
    Route::get('/orders', 'OrderController@index')->name('order.index');
    Route::get('/orders/promoter', 'PromoterController@promoter')->name('order.promoter');
    Route::post('/orders/promoter/records', 'PromoterController@update')->name('order.promoter.update');
    Route::get('/orders/{order}', 'OrderController@show')->name('order.show')->middleware(['auth']);
    Route::post('/orders/{order}/card', 'OrderController@card')->name('order.card');
    Route::post('/orders/{order}/wechat', 'OrderController@wechat')->name('order.wechat');

    Route::get('/physicals/single', 'PhysicalController@index')->name('physical.index');
    Route::get('/physicals/packages', 'PackageController@index')->name('package.index');
    Route::get('/physicals/packages/{package}', 'PackageController@show')->name('package.show');

    Route::get('/advances', 'AdvanceController@index')->name('advance.index');

    Route::group(['middleware' => 'promoter'], function () {
        Route::get('/user/promoter', 'PromoterController@show')->name('promoter.show');
        Route::get('/user/promoter/orders', 'PromoterController@order')->name('promoter.order');
        Route::get('/user/promoter/records', 'PromoterController@record')->name('promoter.record');
        Route::get('/user/promoter/confirms', 'PromoterController@confirm')->name('promoter.confirm');
        Route::post('/user/promoter/statistics/{statistics}/confirm', 'PromoterRecordStatisticsController@confirm')->name('promoter.update');
        Route::get('/promoter/create', 'PromoterController@create')->name('promoter.create');
        Route::post('/promoter', 'PromoterController@store')->name('promoter.store');
    });

    Route::get('/promoter/{promoter}/order/create', 'PromoterOrderController@create')->name('promoter.order.create');
    Route::post('/promoter/{promoter}/order/create', 'PromoterOrderController@store')->name('promoter.order.store');
});
