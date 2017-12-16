<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('/banners', 'BannerController');
    $router->resource('/dynamics', 'DynamicController');
    $router->resource('/specials', 'SpecialController');
    $router->resource('/doctors', 'DoctorController');
    $router->resource('/departments', 'DepartmentController');
    $router->resource('/schedulings', 'SchedulingController');
    $router->resource('/configs', 'ConfigController');
    $router->resource('/nurses', 'NurseController');
    $router->resource('/channels', 'ChannelController');
    $router->resource('/foods', 'FoodController');
    $router->resource('/physicals', 'PhysicalController');
    $router->resource('/packages', 'PackageController');
    $router->resource('/nurse-records', 'CardPayController');
    $router->resource('/promoters', 'PromoterController');
    $router->resource('/promoter-orders', 'PromoterOrderController');
    $router->resource('/promoter-records', 'PromoterRecordController');
    $router->resource('/orders', 'OrderController');
});
