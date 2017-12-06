<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 用户可以更新自己的个人信息
     * @test
     *
     * @return void
     */
    public function users_can_update_their_personal_information()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $this->post('/user', [
            'address' => 'NBYZGC0001',
            'name' => '沈益飞',
            'card' => '330681199309214559',
            'mobile' => '18367831980'
        ]);

        $this->assertEquals($user->fresh()->address, 'NBYZGC0001');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
