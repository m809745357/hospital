<?php

namespace App\Admin\Controllers;

use App\Models\Channel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ChannelController extends Controller
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

            $content->header('菜品分类');
            $content->description('展示菜品分类信息');

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

            $content->header('菜品分类');
            $content->description('展示菜品分类信息');

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

            $content->header('菜品分类');
            $content->description('展示菜品分类信息');

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
        return Admin::grid(Channel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->slug('别名');
            $grid->name('分类名称');
            $grid->describe('分类描述');

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
        return Admin::form(Channel::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('slug', '别名')->help('最好少于5个字，用英文');
            $form->text('name', '分类名称')->help('最好少于5个字');
            $form->textarea('describe', '分类描述')->help('最好少于10个字');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
