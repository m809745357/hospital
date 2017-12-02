<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DynamicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 任何用户都能看到医院动态列表
     * @test
     * @return void
     */
    public function any_user_can_see_a_dynamic_list_of_hospitals()
    {
        $dynamic = factory('App\Models\Dynamic')->create();

        $response = $this->get('/dynamics');

        $response->assertSee($dynamic->title);
    }

    /**
     * 任何用户都能看到医院动态详情
     * @test
     * @return void
     */
    public function any_user_can_see_a_dynamic_detail_of_hospitals()
    {
        $dynamic = factory('App\Models\Dynamic')->create();

        $response = $this->get($dynamic->path());

        $response->assertSee($dynamic->title);
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
