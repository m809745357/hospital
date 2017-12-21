<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderPost;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Nurse;
use EasyWeChat\Foundation\Application;
use App\Models\Ipad;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['notify', 'store', 'show', 'ipad']);
    }

    /**
     * 生成订单
     */
    public function store(CreateOrderPost $request)
    {
        $money = $request->money ?? collect($request->order_details)->sum(function ($detail) {
            return $detail['money'] * $detail['num'];
        });

        $out_trade_no = $this->getOutTradeNo();

        $order_details = serialize($request->order_details);

        if (auth()->check()) {
            $order = auth()->user()->order()->create([
                'money' => $money,
                'out_trade_no' => $out_trade_no,
                'order_details' => $order_details,
                'order_details_type' => $request->order_details_type,
                'order_time' => $request->order_time ?? '',
                'remark' => $request->menu,
            ]);
        } else {
            $order = Order::create([
                'user_id' => 0,
                'money' => $money,
                'out_trade_no' => $out_trade_no,
                'order_details' => $order_details,
                'order_details_type' => $request->order_details_type,
                'order_time' => $request->order_time ?? '',
                'remark' => $request->menu,
            ]);
        }

        return response(['data' => $order], 201);
    }

    public function show(Ipad $ipad, Order $order)
    {
        if ($ipad && $ipad->records()->where('order_id', $order->id)->exists()) {
            return view('mobile.orders.show', compact('order', 'ipad'));
        }

        if (!$ipad && auth()->user()->can('view', $order)) {
            return view('mobile.orders.show', compact('order', 'ipad'));
        }

        return redirect()->back();
    }

    public function index()
    {
        $orders = auth()->user()->order()->latest()->get();
        return view('mobile.orders.index', compact('orders'));
    }

    public function wechat(Request $request, Order $order)
    {
        $app = new Application(config('wechat'));
        $payment = $app->payment;

        if ($order->pay_way === 'ipad') {
            tap($order)->update([
                'order_details' => serialize($order->order_details),
                'out_trade_no' => $this->getOutTradeNo(),
            ]);
        }

        $wxOrder = new \EasyWeChat\Payment\Order($this->getWechatOrder('JSAPI', $order));

        auth()->user()->update(['openid' => 'oktzkwbxksTOGCk9wGLWDV_6gCbA']);
        $result = $payment->prepare($wxOrder);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            tap($order)->update([
                'order_details' => serialize($order->order_details),
                'order_time' => $request->order_time,
                'pay_way' => $request->pay_way,
            ]);

            $prepayId = $result->prepay_id;
            // return response(['data' => $payment->configForJSSDKPayment($prepayId)], 201);
            return response(['data' => $payment->configForPayment($prepayId, false)], 201);
        }
        return response(['data' => $result['err_code_des']], 400);
    }

    public function ipad(Request $request, Ipad $ipad, Order $order)
    {
        $app = new Application(config('wechat'));
        $payment = $app->payment;

        if ($order->pay_way === 'wechat') {
            tap($order)->update([
                'order_details' => serialize($order->order_details),
                'out_trade_no' => $this->getOutTradeNo(),
            ]);
        }

        $wxOrder = new \EasyWeChat\Payment\Order($this->getWechatOrder('NATIVE', $order));

        $result = $payment->prepare($wxOrder);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $code_url = $result->code_url;
            tap($order)->update([
                'order_details' => serialize($order->order_details),
                'order_time' => $request->order_time,
                'pay_way' => $request->pay_way,
            ]);

            $ipad->addIpadRecord([
                'order_id' => $order->id
            ]);

            return response(['data' => \QrCode::size(200)->generate($code_url)], 201);
        }
        return response(['data' => $result['err_code_des']], 400);
    }

    public function getWechatOrder($trade_type, $order)
    {
        return $attributes = [
            'trade_type' => $trade_type, // JSAPI，NATIVE，APP...
            'body' => $this->getBody($order),
            'detail' => $this->getDetail($order),
            'out_trade_no' => $order->out_trade_no,
            // 'total_fee' => $order->money * 100, // 单位：分
            'total_fee' => 1, // 单位：分
            'notify_url' => config('app.url') . '/payment/wechat/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid' => auth()->user() ? auth()->user()->fresh()->openid : '', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
    }

    private function getBody($order)
    {
        switch ($order->order_details_type) {
            case 'App\\Models\\Food':
                return '微信点餐';
                break;
            case 'App\\Models\\Physical': case 'App\\Models\\Package':
                return '预约体检';
                break;
            case 'App\\Models\\Scheduling':
                return '预约挂号';
                break;
        }
    }

    private function getDetail($order)
    {
        switch ($order->order_details_type) {
            case 'App\\Models\\Food':
                return $order->order_details[0]['title'] . '等餐品';
                break;
            case 'App\\Models\\Physical':
                return $order->order_details[0]['title'] . '等单列体检';
                break;
            case 'App\\Models\\Package':
                return $order->order_details['title'] . '套餐体检';
                break;
            case 'App\\Models\\Scheduling':
                return $order->order_details['doctor']['department']['name'] . ' ' . $order->order_details['doctor']['name'];
                break;
        }
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
            'status' => 2,
        ]);

        $nurse->addOrderRecord(['order_id' => $order->id]);

        return response(['data' => $order], 201);
    }

    private function getOutTradeNo()
    {
        return config('wechat.payment.merchant_id') . date('YmdHis') . rand(1000, 9999);
    }

    /**
     * home
     * @param  Application $app wechat
     * @return [type]           [description]
     */
    public function notify(Application $app)
    {
        $response = $app->payment->handleNotify(function ($notify, $successful) {
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = Order::where('out_trade_no', $notify->out_trade_no)->first();

            \Log::info($order);
            $app = new Application(config('wechat'));
            if ($notify->trade_type === 'NATIVE') {
                $openid = $notify->openid;
                $wxuser = $app->user->get($openid);
                $user = User::firstOrNew([
                   'openid' => $openid
                ]);
                if (!$user->exists) {
                    $user->create([
                        'name' => $wxuser->name,
                        'avatar' => $wxuser->headimgurl,
                        'openid' => $wxuser->openid
                    ])->save();
                }
                $order->user_id = $user->id;
            } elseif ($notify->trade_type === 'JSAPI') {
                $user = User::where('openid', $notify->openid)->firstOrFail();
            }
            \Log::info($user);

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->paid_at) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $templateId = 'q7eMJGBtCXDNJUCazF6lI3a2XKz_ENdsyFPCeBU3RVs';
                $url = config('app.url') . '/orders/' . $order->id;
                $data = [
                    'first' => $this->getBody($order) . ', 恭喜你下单成功！',
                    'orderMoneySum' => config('app.name'),
                    'orderProductName' => $order->money . '元',
                    'Remark' => $this->getDetail($order),
                ];
                \Log::info($data);

                $result = $app->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($user->openid)->send();

                \Log::info($result);

                $order->paid_at = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
                $order->status = '2';
            } else { // 用户支付失败
                $order->status = '5';
            }
            $order->save(); // 保存订单
            \Log::info($order);
            return true; // 返回处理完成
        });
        return $response;
    }
}
