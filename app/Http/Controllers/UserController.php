<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPost;
use EasyWeChat\Foundation\Application;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('mobile.user.index');
    }

    public function bind(Application $app)
    {
        return view('mobile.user.bind');
    }

    public function room()
    {
        return view('mobile.user.room');
    }

    public function update(UpdateUserPost $request, Application $app)
    {
        // 实名认证
        $user = auth()->user();

        tap($user)->update($request->validated());

        $templateId = 'vZq5xf_uOSap8bViRoI7WkDHSlDpIMvma-zTPayyTn0';
        $url = route('user.index');
        $data = [
            'first' => $user->name . '，您的个人信息修改成功',
            'keyword1' => date('Y年m月d日'),
            'keyword2' => '绑定手机号码为：' . $user->mobile . '绑定床号为：' . ($user->address ?? '暂无绑定'),
            'remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
        ];
        \Log::info($data);

        $result = $app->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($user->openid)->send();

        return response(['data' => '更新成功'], 201);
    }
}
