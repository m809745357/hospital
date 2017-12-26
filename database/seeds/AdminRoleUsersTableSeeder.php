<?php

use Illuminate\Database\Seeder;

class AdminRoleUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_role_users')->delete();
        
        \DB::table('admin_role_users')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'user_id' => 1,
                'created_at' => '2017-12-25 21:16:30',
                'updated_at' => '2017-12-25 21:16:30',
            ),
            1 => 
            array (
                'role_id' => 2,
                'user_id' => 2,
                'created_at' => '2017-12-25 21:16:30',
                'updated_at' => '2017-12-25 21:16:30',
            ),
            2 => 
            array (
                'role_id' => 3,
                'user_id' => 3,
                'created_at' => '2017-12-25 21:16:30',
                'updated_at' => '2017-12-25 21:16:30',
            ),
        ));
        
        
    }
}