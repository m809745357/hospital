<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderPost;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Nurse;
use EasyWeChat\Foundation\Application;

class OrderController extends Controller
{
    public function store(CreateOrderPost $request)
    {
        $money = $request->money ?? collect($request->order_details)->sum(function ($detail) {
            return $detail['money'] * $detail['num'];
        });

        $out_trade_no = $this->getOutTradeNo();

        $order_details = serialize($request->order_details);

        $order = auth()->user()->order()->create([
            'money' => $money,
            'out_trade_no' => $out_trade_no,
            'order_details' => $order_details,
            'order_details_type' => $request->order_details_type,
            'order_time' => $request->order_time ?? '',
            'remark' => $request->menu
        ]);

        return response(['data' => $order], 201);
    }

    public function show(Order $order)
    {
        return view('mobile.orders.show', compact('order'));
    }

    public function index()
    {
        $orders = auth()->user()->order;
        return view('mobile.orders.index', compact('orders'));
    }

    public function wechat(Request $request, Order $order)
    {
        $app = new Application(config('wechat'));
        $payment = $app->payment;

        $wxOrder = new \EasyWeChat\Payment\Order($this->getWechatOrder('JSAPI', $order));

        auth()->user()->update(['openid' => 'oktzkwbxksTOGCk9wGLWDV_6gCbA']);
        $result = $payment->prepare($wxOrder);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            tap($order)->update([
                'order_time' => $request->order_time,
                'pay_way' => $request->pay_way,
            ]);

            $prepayId = $result->prepay_id;
            return response(['data' => $payment->configForJSSDKPayment($prepayId)], 201);
        }
        return response(['data' => $result['err_code_des']], 400);
    }

    public function ipad(Request $request, Order $order)
    {
        $app = new Application(config('wechat'));
        $payment = $app->payment;

        $wxOrder = new \EasyWeChat\Payment\Order($this->getWechatOrder('NATIVE', $order));

        $result = $payment->prepare($wxOrder);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $code_url = $result->code_url;
            tap($order)->update([
                'order_time' => $request->order_time,
                'pay_way' => $request->pay_way,
            ]);

            return response(['data' => \QrCode::size(200)->generate($code_url)], 201);
        }
        return response(['data' => $result['err_code_des']], 400);
    }

    public function getWechatOrder($trade_type, $order)
    {
        return $attributes = [
            'trade_type' => $trade_type, // JSAPI，NATIVE，APP...
            'body' => '微信点餐',
            'detail' => '微信点餐',
            'out_trade_no' => $order->out_trade_no,
            'total_fee' => $order->money, // 单位：分
            'notify_url' => config('app.url') . '/wechat/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid' => auth()->user()->fresh()->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
    }

    public function card(Request $request, Order $order)
    {
        $secret = $request->secret;
        if (!$secret) {
            return response(['data' => '护士密码不能为空'], 400);
        }

        $nurse = Nurse::where('secret', $secret)->first();

        if (!$nurse) {
            return response(['data' => '密码输入错误'], 400);
        }

        tap($order)->update([
            'order_time' => $request->order_time,
            'pay_way' => $request->pay_way,
            'status' => 2
        ]);

        $nurse->addOrderRecord(['order_id' => $order->id]);

        return response(['data' => $order], 201);
    }

    private function getOutTradeNo()
    {
        return config('wechat.payment.merchant_id') . date('YmdHis') . rand(1000, 9999);
    }
}
