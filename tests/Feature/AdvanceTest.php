<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdvanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 用户可以查看预约挂号列表
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_view_an_appointment_list()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $scheduling = factory('App\Models\Scheduling')->create();

        $response = $this->get('advances');

        $response->assertStatus(302);

        $user->update([
            'card' => '330681199309214559',
            'mobile' => '18367831980',
            'address' => 'NBYZGC0001',
        ]);

        $response = $this->get('/advances');

        $response->assertSee($scheduling->doctor->name);
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
