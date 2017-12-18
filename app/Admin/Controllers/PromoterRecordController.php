<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\PromoterRecord;
use App\Models\PromoterOrder;

class PromoterRecordController extends Controller
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
            $content->header('推广记录');
            $content->description('展示推广记录信息');

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
            $content->header('推广记录');
            $content->description('展示推广记录信息');

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
            $content->header('推广记录');
            $content->description('展示推广记录信息');

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
        return Admin::grid(PromoterRecord::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->column('order.order_no', '订单编号');
            $grid->crown('皇冠');
            $grid->stars('星星');
            $grid->status('是否兑换');

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(PromoterRecord::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->select('promoter_order_id', '转诊订单编号')->options(function ($value) {
                return PromoterOrder::doesntHave('record')->get()->pluck('order_no', 'id');
            });

            $form->promoter_order_id('promoter_order_id', '订单编号');

            $form->number('crown', '皇冠');
            $form->number('stars', '星星');
            $form->select('status', '状态')->options([
                0 => '没有兑换',
                1 => '申请兑换',
                2 => '兑换成功'
            ]);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
