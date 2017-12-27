<?php

namespace App\Admin\Controllers;

use App\Models\PromoterOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Promoter;
use App\Models\Department;

class PromoterOrderController extends Controller
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
            $content->header('推广订单');
            $content->description('展示推广订单信息');

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
            $content->header('推广订单');
            $content->description('展示推广订单信息');

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
            $content->header('推广订单');
            $content->description('展示推广订单信息');

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
        return Admin::grid(PromoterOrder::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->model()->with('record');
            if (Admin::user()->isRole('promoter')) {
                $grid->model()->whereHas('promoter', function ($query) {
                    $query->where('admin_user_id', Admin::user()->id);
                });
            }

            $grid->order_no('订单编号');

            $grid->department_id('部门')->select(Department::all()->pluck('name', 'id'));

            $grid->promoter_id('推广人')->display(function ($promoter_id) {
                return Promoter::find($promoter_id)->user->name;
            });
            $grid->name('姓名')->editable();
            $grid->gender('性别')->select([
                'men' => '男', 'women' => '女'
            ]);
            $grid->mobile('手机号码')->editable();
            $grid->status('是否兑换')->display(function ($status) {
                $statuses = [
                    '0' => '未兑换',
                    '1' => '已兑换'
                ];
                return $statuses[$status];
            })->sortable();

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');

            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器

                $filter->where(function ($query) {
                    $query->where('order_no', 'like', "%{$this->input}%")
                        ->orWhere('order_no', 'like', "%{$this->input}%");
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
        return Admin::form(PromoterOrder::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->select('department_id', '部门')->options(function ($ids) {
                return Department::find($ids)->pluck('name', 'id');
            });
            $form->display('promoter_id', '推广人')->with(function ($id) {
                return Promoter::find($id)->user->name;
            });
            $form->text('name', '姓名');
            $form->select('gender', '性别')->options(['men' => '男', 'women' => '女']);
            $form->mobile('mobile', '手机号码')->options(['mask' => '999 9999 9999']);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
