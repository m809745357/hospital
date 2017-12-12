<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhysicalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 用户可以查看预约单列体检列表
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_view_an_appointment_list_of_physical_examination_lists()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $physicals = factory('App\Models\Physical')->create();

        $response = $this->get('physicals/single');

        $response->assertSee($physicals->title);
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
