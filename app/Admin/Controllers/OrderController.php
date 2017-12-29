<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\OrderType;
use Illuminate\Support\Facades\Request;
use App\Admin\Extensions\Tools\OrderStatus;
use App\Admin\Extensions\Tools\OrderPayWay;
use App\Admin\Extensions\Actions\OrderExchange;
use App\Admin\Extensions\Actions\OrderDeliver;
use App\Admin\Extensions\Actions\OrderRefund;
use EasyWeChat\Foundation\Application;

class OrderController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('订单管理');
            $content->description('展示订单管理信息');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('订单管理');
            $content->description('展示订单管理信息');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('订单管理');
            $content->description('展示订单管理信息');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            if (Admin::user()->isRole('canteen')) {
                $grid->model()->where('status', 'App\\Models\\Food');
            }

            $grid->column('user.name', '下单用户');
            $grid->column('订单详情')->display(function () {
                switch ($this->order_details_type) {
                    case 'App\\Models\\Food':
                        foreach ($this->order_details as $key => $value) {
                            $arr[] = "菜品：{$value['title']} 数量：{$value['num']} 单价：{$value['money']}";
                        }
                        return implode("<br/>", $arr);
                        break;
                    case 'App\\Models\\Physical':
                        foreach ($this->order_details as $key => $value) {
                            $arr[] = "体检：{$value['title']} 数量：{$value['num']} 单价：{$value['money']}";
                        }
                        return implode("<br/>", $arr);
                        break;
                    case 'App\\Models\\Package':
                        return "体检套餐：{$this->order_details['title']} <br/>数量：{$this->order_details['num']} <br/>价格（女）：{$this->order_details['women_money']} <br/>价格（男）：{$this->order_details['men_money']}";
                        break;
                    case 'App\\Models\\Scheduling':
                        return "部门：{$this->order_details['doctor']['department']['name']} <br/>医生：{$this->order_details['doctor']['name']} <br/>地址：{$this->order_details['address']}";
                        break;
                }
            });
            $grid->order_details_type('订单类型')->display(function ($type) {
                $types = [
                    'App\\Models\\Food' => '微信点餐',
                    'App\\Models\\Physical' => '单列体检',
                    'App\\Models\\Package' => '套餐体检',
                    'App\\Models\\Scheduling' => '预约挂号',
                ];
                return $types[$type];
            });
            $grid->money('订单价格（元）')->editable()->sortable();
            $grid->out_trade_no('订单编号');
            $grid->remark('订单备注')->display(function ($remark) {
                if (empty($remark)) {
                    return '暂无备注';
                }
                switch ($remark) {
                    case 'am':
                        return '午餐';
                        break;

                    case 'pm':
                        return '晚餐';
                        break;
                    default:
                        return $remark;
                        break;
                }
            });
            $grid->order_time('订单时间')->display(function ($order_time) {
                if (empty($order_time)) {
                    return '暂无预约时间';
                } else {
                    return $order_time;
                }
            });
            $grid->status('订单状态')->select(['1' => '未支付', '2' => '已支付', '3' => '已兑换/已配送', '4' => '已完成', '5' => '已取消']);
            $grid->pay_way('支付方式')->display(function ($pay_way) {
                if (is_null($pay_way)) {
                    return '未选择';
                }
                $payways = [
                    'wechat' => '微信支付',
                    'card' => '一卡通支付',
                    'ipad' => 'ipad支付',
                ];
                return $payways[$pay_way];
            });
            $grid->disableCreation();
            $grid->disableExport();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            if (Admin::user()->isAdministrator()) {
                $grid->tools(function ($tools) {
                    $tools->append(new OrderType());
                    $tools->append(new OrderStatus());
                    $tools->append(new OrderPayWay());
                });

                if (in_array(Request::get('order-type'), ['App\\Models\\Food', 'App\\Models\\Physical', 'App\\Models\\Package', 'App\\Models\\Scheduling'])) {
                    $grid->model()->where('order_details_type', Request::get('order-type'));
                }

                if (in_array(Request::get('order-status'), ['1', '2', '3', '4', '5'])) {
                    $grid->model()->where('status', Request::get('order-status'));
                }

                if (in_array(Request::get('order-pay-way'), ['wechat', 'card', 'ipad'])) {
                    $grid->model()->where('pay_way', Request::get('order-pay-way'));
                }
            }

            $grid->actions(function ($actions) {
                switch ($actions->row->order_details_type) {
                    case 'App\\Models\\Food':
                        $actions->row->status === '2' && $actions->append(new OrderDeliver($actions->getKey()));
                        break;
                    default:
                        $actions->row->status === '2' && $actions->append(new OrderExchange($actions->getKey()));
                        $actions->row->status === '5' && $actions->append(new OrderRefund($actions->getKey()));
                        break;
                }
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->select('status', '状态')->options(function () {
                return ['1' => '未支付', '2' => '已支付', '3' => '已兑换/已配送', '4' => '已完成', '5' => '已取消', '6' => '已退款'];
            });

            $form->saving(function (Form $form) {
                $form->model()->order_details = serialize($form->model()->order_details);
            });

            $form->saved(function (Form $form) {
                $status = $form->model()->status;
                $user = $form->model()->user;
                switch ($status) {
                    case '3':
                        $data = [
                            'first' => $user->name . '，您的订单已兑换/已配送',
                            'keyword1' => date('Y年m月d日'),
                            'keyword2' => '绑定手机号码为：' . $user->mobile . '绑定床号为：' . ($user->address ?? '暂无绑定'),
                            'remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                    case '4':
                        $data = [
                            'first' => $user->name . '，您的订单已成功',
                            'keyword1' => date('Y年m月d日'),
                            'keyword2' => '绑定手机号码为：' . $user->mobile . '绑定床号为：' . ($user->address ?? '暂无绑定'),
                            'remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                    case '5':
                        $data = [
                            'first' => $user->name . '，您的订单已取消',
                            'keyword1' => date('Y年m月d日'),
                            'keyword2' => '绑定手机号码为：' . $user->mobile . '绑定床号为：' . ($user->address ?? '暂无绑定'),
                            'remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                    case '5':
                        $data = [
                            'first' => $user->name . '，您的订单已退款',
                            'keyword1' => date('Y年m月d日'),
                            'keyword2' => '绑定手机号码为：' . $user->mobile . '绑定床号为：' . ($user->address ?? '暂无绑定'),
                            'remark' => '如果有任何问题请打院所电话咨询，祝您生活愉快！',
                        ];
                        break;
                }
                $app = new Application(config('wechat'));

                $templateId = 'vZq5xf_uOSap8bViRoI7WkDHSlDpIMvma-zTPayyTn0';
                $url = route('order.show', array('order' => $form->model()->id));
                
                \Log::info($data);

                $result = $app->notice->uses($templateId)
                    ->withUrl($url)
                    ->andData($data)
                    ->andReceiver($user->openid)
                    ->send();
            });

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
