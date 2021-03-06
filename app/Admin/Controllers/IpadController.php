<?php

namespace App\Admin\Controllers;

use App\Models\Ipad;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class IpadController extends Controller
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
            $content->header('平板管理');
            $content->description('所有的平板管理列表');

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
            $content->header('平板管理');
            $content->description('所有的平板管理列表');

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
            $content->header('平板管理');
            $content->description('所有的平板管理列表');

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
        return Admin::grid(Ipad::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->name('平板名称')->editable();

            $grid->column('二维码')->display(function () {
                return \QrCode::size(100)->generate(config('app.url') . '/ipads/' . $this->id . '/parcels');
            });

            $grid->column('订餐地址')->display(function () {
                return config('app.url') . '/ipads/' . $this->id . '/parcels';
            });
            $grid->address('病房地址')->limit(20)->editable();
            $grid->remark('备注')->limit(50)->editable();
            $grid->money('累积收益')->sortable();
            $grid->order_num('累积订单')->sortable();
            $states = [
                'on' => ['value' => 1, 'text' => '可用', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '不可用', 'color' => 'default'],
            ];
            $grid->status('状态')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                }, '平板名称');
                $filter->where(function ($query) {
                    $query->where('address', 'like', "%{$this->input}%");
                }, '病房地址');
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
        return Admin::form(Ipad::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('name', '姓名');
            $form->text('address', '病房地址');
            $form->text('money', '累积收益');
            $form->number('order_num', '累积订单');
            $form->remark('备注');

            $states = [
                'on' => ['value' => 1, 'text' => '可用', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '不可用', 'color' => 'default'],
            ];

            $form->switch('status', '状态')->states($states);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
