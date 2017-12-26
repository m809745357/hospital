<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$ffnEW2ftbHLtY8I4gTlOSeHLumbGd3XVTPWhC1ZzD4ME/x2AOv0Cm',
                'name' => '超级管理员',
                'avatar' => 'images/YvgGjPXqhRXtRDwziYwg.png',
                'remember_token' => NULL,
                'created_at' => '2017-12-15 20:36:03',
                'updated_at' => '2017-12-25 21:13:34',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'canteen',
                'password' => '$2y$10$ffnEW2ftbHLtY8I4gTlOSeHLumbGd3XVTPWhC1ZzD4ME/x2AOv0Cm',
                'name' => '食堂管理员',
                'avatar' => 'images/YvgGjPXqhRXtRDwziYwg.png',
                'remember_token' => NULL,
                'created_at' => '2017-12-25 21:16:30',
                'updated_at' => '2017-12-25 21:16:30',
            ),
            2 => 
            array (
                'id' => 3,
                'username' => 'promoter',
                'password' => '$2y$10$ffnEW2ftbHLtY8I4gTlOSeHLumbGd3XVTPWhC1ZzD4ME/x2AOv0Cm',
                'name' => '推广管理员',
                'avatar' => 'images/YvgGjPXqhRXtRDwziYwg.png',
                'remember_token' => NULL,
                'created_at' => '2017-12-25 21:16:30',
                'updated_at' => '2017-12-25 21:16:30',
            ),
        ));
        
        
    }
}