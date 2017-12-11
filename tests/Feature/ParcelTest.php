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
     * 认证用户可以结算点餐订单
     * @test
     *
     * @return void
     */
    public function the_authenticated_user_can_settle_order_orders()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $food = factory('App\Models\Food')->create()->toArray();
        $food['num'] = 5;

        $this->post('/orders', [
            'foods' => [
                $food,
            ],
            'menu' => 'am'
        ]);

        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);
    }

    /**
     * 认证用户可以预览结算点餐界面
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_preview_the_settlement_point_meal_interface()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $food = factory('App\Models\Food')->create()->toArray();
        $food['num'] = 5;

        $order = $user->order()->create([
            'money' => $food['money'] * $food['num'],
            'out_trade_no' => config('wechat.payment.merchant_id') . date('YmdHis') . rand(1000, 9999),
            'foods' => serialize($food),
            'order_time' => '',
            'remark' => 'am'
        ]);

        $response = $this->get($order->path());

        $response->assertSee($order->out_trade_no);
    }

    /**
     * 认证用户可以使用一卡通支付需要护士输入密码
     * @test
     *
     * @return void
     */
    public function the_authenticated_users_can_use_one_card_payment_requires_a_nurse_to_enter_a_password()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $order = factory('App\Models\Order')->create();

        $nurse = factory('App\Models\Nurse')->create();

        $this->post($order->path() . '/card', [
            'order_time' => '11:00-11:30',
            'pay_way' => 'card',
            'secret' => $nurse->secret
        ]);

        $this->assertEquals('card', $order->fresh()->pay_way);

        $this->assertEquals('2', $order->fresh()->status);

        $this->assertEquals($order->money, $nurse->fresh()->money);

        $this->assertDatabaseHas('nurse_records', ['nurse_id' => $nurse->id, 'order_id' => $order->id]);
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
