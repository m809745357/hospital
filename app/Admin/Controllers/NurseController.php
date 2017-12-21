<?php

namespace App\Admin\Controllers;

use App\Models\Nurse;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NurseController extends Controller
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
            $content->header('护士列表');
            $content->description('护士信息用于一卡通支付');

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
            $content->header('护士列表');
            $content->description('护士信息用于一卡通支付');

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
            $content->header('护士列表');
            $content->description('护士信息用于一卡通支付');

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
        return Admin::grid(Nurse::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->avatar('护士头像')->image(50, 50);
            $grid->name('护士姓名')->editable();
            $grid->secret('护士密码')->editable();
            $grid->order_num('支付次数（次）')->sortable();
            $grid->money('护士收益（元）')->sortable();

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
        return Admin::form(Nurse::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->image('avatar', '护士头像')->removable()->crop(200, 200)->help('推荐像素 200 * 200');
            $form->text('name', '护士姓名')->help('最好少于5个字');
            $form->text('secret', '护士密码')->help('最好少于6个字');
            $form->text('money', '累积收益');
            $form->text('order_num', '支付次数');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
