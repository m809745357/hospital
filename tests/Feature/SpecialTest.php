<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpecialTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 所有人都可以查看医疗特色
     * @test
     *
     * @return void
     */
    public function any_user_can_see_a_special_list_of_hospitals()
    {
        $special = factory('App\Models\Special')->create();

        $response = $this->get('/specials');

        $response->assertSee($special->title);
    }

    /**
     * 所有人都可以查看医疗特色详情
     *
     * @test
     *
     * @return void
     */
    public function any_user_can_see_a_special_detail_of_hospitals()
    {
        $special = factory('App\Models\Special')->create(['status' => 1]);
        // dd($special);
        $response = $this->get($special->path());

        $response->assertSee($special->title);
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
