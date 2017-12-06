<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParcelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 认证用户可以查看点餐列表
     * @test
     *
     * @return void
     */
    public function the_authenticated_user_can_view_the_table_list()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $food = factory('App\Models\Food')->create();

        $response = $this->get('/parcels');

        $response->assertSee($food->title);
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
