<?php

use Illuminate\Database\Seeder;

class AdminRolePermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_role_permissions')->delete();
        
        \DB::table('admin_role_permissions')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'permission_id' => 1,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            1 => 
            array (
                'role_id' => 2,
                'permission_id' => 2,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            2 => 
            array (
                'role_id' => 2,
                'permission_id' => 3,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            3 => 
            array (
                'role_id' => 2,
                'permission_id' => 4,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            4 => 
            array (
                'role_id' => 3,
                'permission_id' => 2,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            5 => 
            array (
                'role_id' => 3,
                'permission_id' => 3,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            6 => 
            array (
                'role_id' => 3,
                'permission_id' => 4,
                'created_at' => '2017-12-25 21:13:05',
                'updated_at' => '2017-12-25 21:13:05',
            ),
            7 => 
            array (
                'role_id' => 3,
                'permission_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'role_id' => 2,
                'permission_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}