<?php

use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('configs')->delete();
        
        \DB::table('configs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => 'logo',
                'contact' => 'images/logo.png',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:39:21',
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => 'bottom_logo',
                'contact' => 'images/bottom_logo.png',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:39:38',
            ),
            2 => 
            array (
                'id' => 3,
                'slug' => 'qrcode',
                'contact' => 'images/qrcode.png',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:39:49',
            ),
            3 => 
            array (
                'id' => 4,
                'slug' => 'site_title',
                'contact' => '宁波鄞州肛肠医院',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:41:07',
            ),
            4 => 
            array (
                'id' => 5,
                'slug' => 'address',
                'contact' => '浙江省宁波市鄞州区科技路355号',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:42:52',
            ),
            5 => 
            array (
                'id' => 6,
                'slug' => 'phone',
                'contact' => '0574-88990088',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:43:07',
            ),
            6 => 
            array (
                'id' => 7,
                'slug' => 'url',
                'contact' => 'https://www.nbyzgc.com',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:43:27',
            ),
            7 => 
            array (
                'id' => 8,
                'slug' => 'mail',
                'contact' => 'company@nbyzgc.com',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:44:08',
            ),
            8 => 
            array (
                'id' => 9,
                'slug' => 'lat',
                'contact' => '29.8297500000',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:48:37',
            ),
            9 => 
            array (
                'id' => 10,
                'slug' => 'lng',
                'contact' => '121.5750600000',
                'created_at' => '2017-12-15 20:35:36',
                'updated_at' => '2017-12-15 20:48:48',
            ),
            10 => 
            array (
                'id' => 11,
                'slug' => 'introduce',
                'contact' => '123',
                'created_at' => '2017-12-15 20:52:24',
                'updated_at' => '2017-12-15 20:52:34',
            ),
            11 => 
            array (
                'id' => 12,
                'slug' => 'secret',
                'contact' => '123456',
                'created_at' => '2017-12-15 20:52:24',
                'updated_at' => '2017-12-15 20:52:34',
            ),
        ));
        
        
    }
}