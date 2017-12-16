<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 用户可以登记成为推广者
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_register_as_promoters()
    {
        $user = factory('App\User')->create([
            'mobile' => '18367831980',
            'card' => '330681199309214559',
        ]);
        $this->actingAs($user);

        $this->post('promoter', [
            'hospital' => '诸暨市人民医院',
            'department' => '皮肤科',
            'job_title' => '主治医生'
        ]);

        $this->assertDatabaseHas('promoters', ['user_id' => $user->id]);
    }

    /**
     * 用户可以生成转诊订单
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_create_promoter_order()
    {
        $promoter = factory('App\Models\Promoter')->create();

        $user = factory('App\User')->create([
            'mobile' => '18367831980',
            'card' => '330681199309214559',
        ]);
        $this->actingAs($user);

        $promoterOrder = factory('App\Models\PromoterOrder')->make();

        $this->post($promoter->path() . '/order/create', $promoterOrder->toArray());

        $this->assertDatabaseHas('promoter_orders', ['promoter_id' => $promoter->id]);
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
