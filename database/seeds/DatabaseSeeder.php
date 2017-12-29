<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
        $this->call(AdminPermissionsTableSeeder::class);
        $this->call(AdminRoleMenuTableSeeder::class);
        $this->call(AdminRolePermissionsTableSeeder::class);
        $this->call(AdminRoleUsersTableSeeder::class);
        $this->call(AdminRolesTableSeeder::class);
        $this->call(AdminUserPermissionsTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);

        factory('App\Models\Banner', 6)->create();
        factory('App\Models\Ipad', 20)->create();
        factory('App\Models\Dynamic', 10)->create();
        factory('App\Models\Special', 6)->create();
        factory('App\Models\Department', 6)->create();
        factory('App\Models\Nurse', 6)->create();
        factory('App\Models\Channel', 6)->create();
        factory('App\Models\Package', 10)->create();

        $user = factory('App\User')->create([
            'card' => '330681199309214559',
            'mobile' => '18367831980',
            'address' => 'NBYZGC0001',
            'name' => '沈益飞',
            'openid' => 'oFVoa1gJ7i8000kKuVnnQMWQgcCo',
            'avatar' => 'http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJPu1sSYJ1XWRYCaTBffZ0fI0lFwqHXiaMIxTNA6TnVBjqE3QXO6qwDkoyAmKI1aqgEZu4uUWpoHrA/0',
            'certification' => 1
        ]);

        $promoter = factory('App\Models\Promoter')->create();
        $promoter->user->update(['role' => 'promoter']);

        for ($i = 1; $i <= 6; $i++) {
            factory('App\Models\Food', 3)->create(['channel_id' => $i]);
            factory('App\Models\Physical', 3)->create(['department_id' => $i]);
            factory('App\Models\Doctor', 3)->create(['department_id' => $i]);

            factory('App\Models\PromoterOrder', 3)->create([
                'department_id' => $i,
                'promoter_id' => 1
            ]);
        }

        for ($i = 1; $i <= 18; $i++) {
            factory('App\Models\Scheduling', 3)->create(['doctor_id' => $i]);
        }
    }
}
