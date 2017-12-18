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

            $grid->column('user.name', '下单用户');
            // $grid->order_details('订单详情');
            $grid->order_details_type('订单类型');
            $grid->money('订单价格');
            $grid->out_trade_no('订单编号');
            $grid->remark('订单备注');
            $grid->order_time('订单时间');
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

            $grid->tools(function ($tools) {
                $tools->append(new OrderType());
            });

            if (in_array(Request::get('order-type'), ['App\\Models\\Food', 'App\\Models\\Physical', 'App\\Models\\Package', 'App\\Models\\Scheduling'])) {
                $grid->model()->where('order_details_type', Request::get('order-type'));
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
