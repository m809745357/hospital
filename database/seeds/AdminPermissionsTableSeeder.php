<?php

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_permissions')->delete();
        
        \DB::table('admin_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '全部权限',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '仪表板',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '登录',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
/auth/logout',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '用户设置',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '授权管理',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '推广管理',
                'slug' => 'promoter',
                'http_method' => '',
                'http_path' => '/promoters*
/promoter-records*
/promoter-orders*',
                'created_at' => '2017-12-26 22:10:03',
                'updated_at' => '2017-12-26 22:10:03',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '微信点餐',
                'slug' => 'canteen',
                'http_method' => '',
                'http_path' => '/channels*
/foods*
/orders*',
                'created_at' => '2017-12-27 00:22:42',
                'updated_at' => '2017-12-27 00:23:20',
            ),
        ));
        
        
    }
}