<?php

namespace App\Admin\Controllers;

use App\Models\IpadRecord;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class IpadRecordController extends Controller
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
            $content->header('平板支付');
            $content->description('使用平板支付的记录展示');

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
            $content->header('平板支付');
            $content->description('使用平板支付的记录展示');

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
            $content->header('平板支付');
            $content->description('使用平板支付的记录展示');

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
        return Admin::grid(IpadRecord::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->column('ipad.name', '平板名称');
            $grid->column('order.out_trade_no', '订单编号');

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');

            $grid->disableCreation();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->where(function ($query) {
                    $query->whereHas('ipad', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '平板名称');
                $filter->where(function ($query) {
                    $query->whereHas('order', function ($query) {
                        $query->where('out_trade_no', 'like', "%{$this->input}%");
                    });
                }, '订单编号');
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
        return Admin::form(IpadRecord::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
