<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('/dynamics', 'DynamicController');
    $router->resource('/specials', 'SpecialController');
    $router->resource('/doctors', 'DoctorController');
    $router->resource('/departments', 'DepartmentController');
    $router->resource('/schedulings', 'SchedulingController');
    $router->resource('/configs', 'ConfigController');
});
