<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 1,
                'title' => '系统管理',
                'icon' => 'fa-tasks',
                'uri' => NULL,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            1 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 2,
                'title' => '后台用户',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            2 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 3,
                'title' => '用户角色',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            3 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 4,
                'title' => '后台权限',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            4 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 5,
                'title' => '菜单管理',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            5 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 6,
                'title' => '操作日志',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            6 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 7,
                'title' => '医院官网',
                'icon' => 'fa-hospital-o',
                'uri' => NULL,
                'created_at' => '2017-12-15 20:59:35',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            7 => 
            array (
                'id' => 9,
                'parent_id' => 8,
                'order' => 9,
                'title' => '医院动态',
                'icon' => 'fa-newspaper-o',
                'uri' => 'dynamics',
                'created_at' => '2017-12-15 21:00:13',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            8 => 
            array (
                'id' => 10,
                'parent_id' => 8,
                'order' => 10,
                'title' => '医疗特色',
                'icon' => 'fa-stethoscope',
                'uri' => 'specials',
                'created_at' => '2017-12-15 21:01:56',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            9 => 
            array (
                'id' => 11,
                'parent_id' => 8,
                'order' => 8,
                'title' => '官网轮播',
                'icon' => 'fa-image',
                'uri' => 'banners',
                'created_at' => '2017-12-15 21:02:44',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            10 => 
            array (
                'id' => 12,
                'parent_id' => 8,
                'order' => 11,
                'title' => '官网设置',
                'icon' => 'fa-cogs',
                'uri' => 'configs',
                'created_at' => '2017-12-15 21:03:30',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            11 => 
            array (
                'id' => 13,
                'parent_id' => 0,
                'order' => 12,
                'title' => '门诊预约',
                'icon' => 'fa-ambulance',
                'uri' => NULL,
                'created_at' => '2017-12-15 21:05:21',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            12 => 
            array (
                'id' => 14,
                'parent_id' => 13,
                'order' => 13,
                'title' => '部门',
                'icon' => 'fa-codepen',
                'uri' => 'departments',
                'created_at' => '2017-12-15 21:05:42',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            13 => 
            array (
                'id' => 15,
                'parent_id' => 13,
                'order' => 14,
                'title' => '医生',
                'icon' => 'fa-stethoscope',
                'uri' => 'doctors',
                'created_at' => '2017-12-15 21:06:27',
                'updated_at' => '2017-12-15 21:24:05',
            ),
            14 => 
            array (
                'id' => 16,
                'parent_id' => 13,
                'order' => 16,
                'title' => '排班',
                'icon' => 'fa-align-justify',
                'uri' => 'schedulings',
                'created_at' => '2017-12-15 21:07:02',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            15 => 
            array (
                'id' => 17,
                'parent_id' => 0,
                'order' => 17,
                'title' => '微信点餐',
                'icon' => 'fa-comments',
                'uri' => NULL,
                'created_at' => '2017-12-15 21:08:29',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            16 => 
            array (
                'id' => 18,
                'parent_id' => 17,
                'order' => 18,
                'title' => '菜品分类',
                'icon' => 'fa-certificate',
                'uri' => 'channels',
                'created_at' => '2017-12-15 21:09:00',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            17 => 
            array (
                'id' => 19,
                'parent_id' => 17,
                'order' => 19,
                'title' => '菜品展示',
                'icon' => 'fa-leanpub',
                'uri' => 'foods',
                'created_at' => '2017-12-15 21:10:08',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            18 => 
            array (
                'id' => 20,
                'parent_id' => 0,
                'order' => 20,
                'title' => '预约体检',
                'icon' => 'fa-android',
                'uri' => NULL,
                'created_at' => '2017-12-15 21:11:46',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            19 => 
            array (
                'id' => 21,
                'parent_id' => 20,
                'order' => 21,
                'title' => '单例体检',
                'icon' => 'fa-map-signs',
                'uri' => 'physicals',
                'created_at' => '2017-12-15 21:12:30',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            20 => 
            array (
                'id' => 22,
                'parent_id' => 20,
                'order' => 22,
                'title' => '套餐体检',
                'icon' => 'fa-meanpath',
                'uri' => 'packages',
                'created_at' => '2017-12-15 21:13:00',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            21 => 
            array (
                'id' => 23,
                'parent_id' => 0,
                'order' => 23,
                'title' => '支付方式',
                'icon' => 'fa-bar-chart',
                'uri' => NULL,
                'created_at' => '2017-12-15 21:14:08',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            22 => 
            array (
                'id' => 24,
                'parent_id' => 23,
                'order' => 24,
                'title' => '一卡通',
                'icon' => 'fa-credit-card',
                'uri' => 'nurse-records',
                'created_at' => '2017-12-15 21:14:56',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            23 => 
            array (
                'id' => 26,
                'parent_id' => 32,
                'order' => 33,
                'title' => '所有订单',
                'icon' => 'fa-reorder',
                'uri' => 'orders',
                'created_at' => '2017-12-15 21:20:20',
                'updated_at' => '2017-12-21 23:42:58',
            ),
            24 => 
            array (
                'id' => 27,
                'parent_id' => 0,
                'order' => 26,
                'title' => '转诊管理',
                'icon' => 'fa-automobile',
                'uri' => NULL,
                'created_at' => '2017-12-15 21:23:24',
                'updated_at' => '2017-12-21 23:42:58',
            ),
            25 => 
            array (
                'id' => 28,
                'parent_id' => 27,
                'order' => 27,
                'title' => '推广医生',
                'icon' => 'fa-briefcase',
                'uri' => 'promoters',
                'created_at' => '2017-12-15 21:26:48',
                'updated_at' => '2017-12-21 23:42:58',
            ),
            26 => 
            array (
                'id' => 29,
                'parent_id' => 27,
                'order' => 28,
                'title' => '推广记录',
                'icon' => 'fa-align-justify',
                'uri' => 'promoter-records',
                'created_at' => '2017-12-15 21:27:38',
                'updated_at' => '2017-12-21 23:42:58',
            ),
            27 => 
            array (
                'id' => 30,
                'parent_id' => 27,
                'order' => 29,
                'title' => '推广订单',
                'icon' => 'fa-archive',
                'uri' => 'promoter-orders',
                'created_at' => '2017-12-15 21:28:17',
                'updated_at' => '2017-12-21 23:42:58',
            ),
            28 => 
            array (
                'id' => 31,
                'parent_id' => 13,
                'order' => 15,
                'title' => '护士',
                'icon' => 'fa-calendar-minus-o',
                'uri' => 'nurses',
                'created_at' => '2017-12-15 21:59:14',
                'updated_at' => '2017-12-15 21:59:20',
            ),
            29 => 
            array (
                'id' => 32,
                'parent_id' => 0,
                'order' => 30,
                'title' => '用户管理',
                'icon' => 'fa-users',
                'uri' => NULL,
                'created_at' => '2017-12-21 23:04:26',
                'updated_at' => '2017-12-21 23:42:58',
            ),
            30 => 
            array (
                'id' => 33,
                'parent_id' => 32,
                'order' => 31,
                'title' => '微信用户',
                'icon' => 'fa-user',
                'uri' => 'users',
                'created_at' => '2017-12-21 23:05:23',
                'updated_at' => '2017-12-21 23:42:58',
            ),
            31 => 
            array (
                'id' => 34,
                'parent_id' => 23,
                'order' => 25,
                'title' => '平板支付',
                'icon' => 'fa-clipboard',
                'uri' => 'ipad-records',
                'created_at' => '2017-12-21 23:22:43',
                'updated_at' => '2017-12-21 23:43:12',
            ),
            32 => 
            array (
                'id' => 35,
                'parent_id' => 32,
                'order' => 32,
                'title' => '平板管理',
                'icon' => 'fa-mobile-phone',
                'uri' => 'ipads',
                'created_at' => '2017-12-21 23:42:42',
                'updated_at' => '2017-12-21 23:42:58',
            ),
        ));
        
        
    }
}