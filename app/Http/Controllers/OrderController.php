<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderPost;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Nurse;

class OrderController extends Controller
{
    public function store(CreateOrderPost $request)
    {
        $money = collect($request->order_details)->sum(function ($detail) {
            return $detail['money'] * $detail['num'];
        });

        $out_trade_no = $this->getOutTradeNo();

        $order_details = serialize($request->order_details);

        $order = auth()->user()->order()->create([
            'money' => $money,
            'out_trade_no' => $out_trade_no,
            'order_details' => $order_details,
            'order_details_type' => $request->order_details_type,
            'order_time' => '',
            'remark' => $request->menu
        ]);

        return response(['data' => $order], 201);
    }

    public function show(Order $order)
    {
        return view('mobile.orders.show', compact('order'));
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
