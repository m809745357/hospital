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
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => NULL,
                'created_at' => '2017-12-15 20:36:03',
                'updated_at' => '2017-12-15 20:36:03',
            ),
        ));
        
        
    }
}