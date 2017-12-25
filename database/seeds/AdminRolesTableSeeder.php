<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_roles')->delete();
        
        \DB::table('admin_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '超级管理员',
                'slug' => 'administrator',
                'created_at' => '2017-12-15 20:36:03',
                'updated_at' => '2017-12-25 21:12:04',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '食堂',
                'slug' => 'canteen',
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
        ));
        
        
    }
}