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

            $grid->column('department.name', '部门');
            $grid->promoter_id('推广人')->display(function ($promoter_id) {
                return Promoter::find($promoter_id)->user->name;
            });
            $grid->name('姓名');
            $grid->gender('性别')->select([
                'men' => '男', 'women' => '女'
            ]);
            $grid->mobile('手机号码');


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
