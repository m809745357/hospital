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
        $name = $request->name;
        $card = $request->card;
        if (config('app.debug') && $card && $name) {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'http://op.juhe.cn/idcard/query', [
                'query' => "realname={$name}&idcard={$card}&key=ceb8ddb853f24618b475aae5d76afd70"
            ]);
            $arr = json_decode($res->getBody()->getContents(), true);
            if (!($arr['error_code'] == 0 && $arr['result']['res'] == 1)) {
                return response(['data' => '身份证和姓名不匹配，请重新输入'], 400);
            }
            tap($user)->update(['certification' => 1]);
        }
        $user = auth()->user();

        tap($user)->update($request->validated());

        $templateId = config('wechat.template.user_edit');
        $url = route('user.index');
        $data = [
            'first' => $user->name . '，您的个人信息修改成功',
            'keyword1' => date('Y年m月d日'),
            'keyword2' => '绑定手机号码为：' . $user->mobile . '绑定床号为：' . ($user->address ?? '暂无绑定'),
            'remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
        ];
        \Log::info($data);

        config('app.debug') || $result = $app->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($user->openid)->send();

        return response(['data' => '更新成功'], 201);
    }
}
