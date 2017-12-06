<?php

namespace App\Http\Controllers;

use App\Notifications\SmsNotification;
use Illuminate\Http\Request;
use App\Models\Sms;
use App\Http\Requests\CreateSmsPost;

class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(CreateSmsPost $request)
    {
        if (auth()->user()->mobileExists()) {
            return response(['data' => '手机号码已经被他人注册'], 400);
        }

        \Notification::send(auth()->user(), new SmsNotification($request->mobile));

        return response(['data' => '短信发送成功'], 201);
    }

    public function update(Request $request)
    {
        $sms = Sms::whereNull('read_at')->where('mobile', $request->mobile)->first();
        $this->authorize('update', $sms);

        if ($sms->validateMobile()) {
            return response(['data' => '验证成功'], 201);
        }

        return response(['data' => '验证失败', 'sms' => $sms], 400);
    }
}
