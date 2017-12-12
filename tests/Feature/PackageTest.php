<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 用户可以查看预约套餐体检列表
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_see_the_checklist_for_the_reservation_set()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $packages = factory('App\Models\Package')->create();

        $response = $this->get('physicals/packages');

        $response->assertSee($packages->title);
    }

    /**
     * 用户可以查看预约套餐体检详情
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_see_the_details_of_the_reservation_package_for_physical_examination()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $package = factory('App\Models\Package')->create();

        $response = $this->get('physicals/packages/' . $package->id);

        $response->assertSee($package->title);
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
