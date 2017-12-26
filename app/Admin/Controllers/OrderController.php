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
            // $grid->order_details('订单详情');
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
            $grid->status('订单状态')->display(function ($status) {
                $statuses = [
                    '1' => '未支付',
                    '2' => '已支付',
                    '3' => '已完成',
                    '4' => '已取消',
                    '5' => '已配送'
                ];
                return $statuses[$status];
            });
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

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
