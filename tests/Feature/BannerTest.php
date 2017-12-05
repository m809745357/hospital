<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BannerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 任何页面都有 banner 页面
     * @test
     *
     * @return void
     */
    public function any_page_has_a_banner()
    {
        $banner = factory('App\Models\Banner')->create();

        $response = $this->get('/home');

        $response->assertSee($banner->title);
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
