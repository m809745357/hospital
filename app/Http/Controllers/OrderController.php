<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderPost;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Nurse;
use EasyWeChat\Foundation\Application;
use App\Models\Ipad;
use App\User;
use App\Jobs\CancelOrder;
use Carbon\Carbon;
use App\Models\IpadRecord;
use App\Models\Config;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['notify', 'store', 'show', 'ipad']);
    }

    /**
     * 生成订单
     */
    public function store(CreateOrderPost $request, Ipad $ipad)
    {
        // 单独针对微信点餐
        if ($request->order_details_type === "App\Models\Food") {
            $configs = Config::where('slug', 'business')->first();
            $judge = false;
            $now = Carbon::now();
            foreach (explode("\r\n", $configs->contact) as $value) {
                $arr = explode('-', $value);
                $start_time = Carbon::parse(date("Y-m-d $arr[0]"));
                $end_time = Carbon::parse(date("Y-m-d $arr[1]"));
                if ($now->gte($start_time) && $now->lte($end_time)) {
                    $judge = true;
                    break;
                }
            }
            if (! $judge) {
                return response(['data' => '食堂不在营业中不接受订餐'], 400);
            }
        }

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
            IpadRecord::create([
                'ipad_id' => $ipad->id,
                'order_id' => $order->id
            ]);
        }

        config('app.debug') || CancelOrder::dispatch($order)
                ->delay(Carbon::now()->addMinutes(15));

        return response(['data' => $order], 201);
    }

    public function show(Ipad $ipad, Order $order)
    {
        if ($ipad && $ipad->records()->where('order_id', $order->id)->exists()) {
            return view('mobile.orders.show', compact('order', 'ipad'));
        }

        if (!$ipad->exists && auth()->user()->can('view', $order)) {
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

            return response(['data' => \QrCode::size(300)->generate($code_url)], 201);
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
            'total_fee' => config('app.debug') ? 1 : $order->money * 100, // 单位：分
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

    public function card(Request $request, Order $order, Application $app)
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

        $user = auth()->user();

        $url = route('order.show', ['order' => $order->id]);
        $templateId = '6U64VpcD1B66eXgLjoiy4kGz5e5lY0KrnURK2Sl0e7c';
        $data = [
            'first' => $user->name . ', 恭喜你点餐成功！',
            'keyword1' => $order->out_trade_no,
            'keyword2' => $user->address,
            'keyword3' => '医院配送',
            'keyword4' => $user->mobile,
            'keyword5' => "￥{$order->money}元",
            'Remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
        ];
        $result = $app->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($user->openid)->send();

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
                $address = $order->ipadRecord->ipad->address;
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
                $url = route('order.show', ['order' => $order->id]);

                switch ($order->order_details_type) {
                    case 'App\\Models\\Food':
                        $templateId = '6U64VpcD1B66eXgLjoiy4kGz5e5lY0KrnURK2Sl0e7c';
                        $data = [
                            'first' => $user->name . ', 恭喜你点餐成功！',
                            'keyword1' => $order->out_trade_no,
                            'keyword2' => $notify->trade_type === 'NATIVE' ? $address : $user->address,
                            'keyword3' => '医院配送',
                            'keyword4' => $user->mobile,
                            'keyword5' => "￥{$order->money}元",
                            'Remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                    case 'App\\Models\\Physical':
                        $templateId = 'seR-235joBnODL78IKmAMxtLuMa44KG8w-6J3inLGpA';
                        $genders = [
                            0 => '未知',
                            1 => '男',
                            2 => '女'
                        ];
                        $data = [
                            'first' => '恭喜你预约体检成功！订单流水号：' . $order->out_trade_no,
                            'keyword1' => $user->name,
                            'keyword2' => $genders[$user->gender],
                            'keyword3' => $user->mobile,
                            'keyword4' => $order->order_details[0]['title'] . '等单列体检',
                            'keyword5' => $order->order_time,
                            'Remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                    case 'App\\Models\\Package':
                        $templateId = 'seR-235joBnODL78IKmAMxtLuMa44KG8w-6J3inLGpA';
                        $genders = [
                            0 => '未知',
                            1 => '男',
                            2 => '女'
                        ];
                        $gender = $user->gender == null ?? 0;
                        $data = [
                            'first' => '恭喜你预约体检成功！订单流水号：' . $order->out_trade_no,
                            'keyword1' => $user->name,
                            'keyword2' => $genders[$gender],
                            'keyword3' => $user->mobile,
                            'keyword4' => $order->order_details['title'] . '套餐体检',
                            'keyword5' => $order->order_time,
                            'Remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                    case 'App\\Models\\Scheduling':
                        $templateId = 'JsxDNEqyMhtbwU9ZfpjhbrOQtzkF0bVD4yCDHCgUFGI';
                        $genders = [
                            0 => '未知',
                            1 => '男',
                            2 => '女'
                        ];
                        $configs = \App\Models\Config::all()->pluck('contact', 'slug');
                        $data = [
                            'first' => $user->name . ', 您好，请预约了门诊，请及时前往医院取号就诊。',
                            'patientName' => $user->name,
                            'patientSex' => $genders[$user->gender],
                            'hospitalName' => $configs['site_title'],
                            'hospitalTel' => $configs['phone'],
                            'hospitalAddress' => $configs['address'],
                            'department' => $order->order_details['doctor']['department']['name'],
                            'doctor' => $order->order_details['doctor']['name'],
                            'seq' => $order->out_trade_no,
                            'Remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                }

                // 不是已经支付状态则修改为已经支付状态

                \Log::info($data);

                $result = $app->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($user->openid)->send();

                \Log::info($result);

                $order->paid_at = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
                $order->status = '2';
            } else { // 用户支付失败
                $order->status = '5';
            }
            $order->order_details = serialize($order->order_details);
            $order->save(); // 保存订单
            \Log::info($order);
            return true; // 返回处理完成
        });
        return $response;
    }
}
