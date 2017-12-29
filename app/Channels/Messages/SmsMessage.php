<?php

namespace App\Channels\Messages;

use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use App\Models\Sms;

class SmsMessage
{
    /**
     * 发送短信
     *
     * @param  [type] $mobile [description]
     * @param  [type] $code   [description]
     * @return [type]         [description]
     */
    public function sendSms($user, $mobile)
    {
        $config = config('easy-sms.config');
        try {
            $easySms = new EasySms($config);

            $code = rand(1000, 9999);
            if (config('app.debug')) {
                $easySms->send($mobile, [
                    'template' => 'SMS_76020350',
                    'data' => [
                        'code' => $code,
                        'product' => 'code'
                    ],
                ], ['aliyun']);
            } else {
                $easySms->send($mobile, [
                'template' => '58221',
                'data' => [
                    'code' => $code,
                    'product' => 'code'
                ],
            ], ['juhe']);
            }
        } catch (NoGatewayAvailableException $e) {
            throw new Exception('短信发送失败');
        }
        $user->markSmsAsRead();
        $user->addSms(['mobile' => $mobile, 'code' => $code]);
    }
}
