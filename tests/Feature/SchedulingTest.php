<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchedulingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 任何一个用户可以看到排班信息
     * @test
     *
     * @return void
     */
    public function any_user_can_see_a_scheduling_list_of_hospital()
    {
        $doctor = factory('App\Models\Doctor')->create();

        $schedulings = factory('App\Models\Scheduling')->create(['doctor_id' => $doctor->id]);

        $response = $this->get('/schedulings');

        $response->assertSee($doctor->name)
            ->assertSee($doctor->department->name);
    }

    /*
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
