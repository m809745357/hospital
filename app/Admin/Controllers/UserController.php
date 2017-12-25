<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\User;

class UserController extends Controller
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
            $content->header('用户管理');
            $content->description('管理用户相关信息展示');

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
            $content->header('用户管理');
            $content->description('管理用户相关信息展示');

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
            $content->header('用户管理');
            $content->description('管理用户相关信息展示');

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
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->avatar('头像')->image(50, 50);
            $grid->name('姓名')->editable();
            $grid->openid('微信编号');
            $grid->mobile('手机号码')->editable();
            $grid->card('身份证')->editable();
            $grid->address('床位')->editable();
            $grid->role('角色')->select([
                'normal' => '普通用户',
                'promoter' => '转诊医生',
            ]);

            $grid->remark('备注')->editable('textarea');

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
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('name', '姓名');
            $form->mobile('mobile', '手机号码')->options(['mask' => '99999999999']);
            $form->text('card', '身份证');
            $form->text('address', '床位');
            $form->textarea('remark', '备注');
            $form->select('role', '角色')->options([
                'normal' => '普通用户',
                'promoter' => '转诊医生',
            ]);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
