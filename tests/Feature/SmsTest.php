<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SmsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 任何微信用户都可以发送短信到手机号码中
     * @test
     *
     * @return void
     */
    public function any_wechat_user_can_send_sms_to_the_phone_number()
    {
        $user = factory('App\User')->create(['mobile' => '18367831980']);
        $this->actingAs($user);

        $this->withExceptionHandling();

        $response = $this->post('/sms', [
            'mobile' => '18367831980'
        ]);

        $response->assertStatus(400);

        $response = $this->post('/sms', [
            'mobile' => '18367831981'
        ]);

        $this->assertDatabaseHas('sms', ['user_id' => $user->id]);
    }

    /**
     * 验证号码的时候只能是发送短信的手机号码
     * @test
     *
     * @return void
     */
    public function the_verifying_number_is_only_the_phone_number_that_sends_the_message()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $sms = factory('App\Models\Sms')->create(['user_id' => $user->id]);

        $this->withExceptionHandling();

        $response = $this->post('/sms/1836781988', [
            'code' => 666666
        ]);

        $response->assertStatus(403);

        $this->withExceptionHandling();

        $response = $this->post($sms->path(), [
            'code' => 666666
        ]);

        $this->assertTrue(!$sms->fresh()->isNotRead());
    }

    /**
     * 短信验证成功案例
     * @test
     * @return void
     */
    public function sms_valiation()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $sms = factory('App\Models\Sms')->create(['user_id' => $user->id]);

        $this->withExceptionHandling();

        $response = $this->post($sms->path(), [
            'code' => 666661
        ]);

        $response->assertStatus(400);

        $response = $this->post($sms->path(), [
            'code' => 666666
        ]);

        $response->assertStatus(201);
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
