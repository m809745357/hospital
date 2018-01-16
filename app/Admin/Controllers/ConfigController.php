<?php

namespace App\Admin\Controllers;

use App\Models\Config;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ConfigController extends Controller
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
            $content->header('官网配置');
            $content->description('展示官网配置信息');

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
            $content->header('官网配置');
            $content->description('展示官网配置信息');

            $content->body($this->form($id)->edit($id));
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
            $content->header('官网配置');
            $content->description('展示官网配置信息');

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
        return Admin::grid(Config::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->slug('别名');
            $grid->contact('内容')->display(function ($value) {
                if ($this->id == 11) {
                    return '<a href="/introduce" target="new_window">官网介绍</a>';
                }
                if (preg_match('/(.*?(jpg|jpeg|gif|png))/', $value)) {
                    return '<img src="' . config('app.url') . '/uploads/' . $value . '" style="witdh:90px;height:90px;">';
                }
                return $value;
            });

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            $grid->disableCreation();
            $grid->disableExport();
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
    protected function form($id = '')
    {
        return Admin::form(Config::class, function (Form $form) use ($id) {
            $form->display('id', 'ID');

            $form->text('slug', '别名');
            $id || $id = request()->config;
            if ($id <= 3) {
                $form->image('contact', '内容');
            } elseif ($id == 11) {
                $form->editor('contact', '内容')->help('图片压缩地址：<a href="https://tinypng.com/" target="view_window">https://tinypng.com/</a>');
            } else {
                $form->textarea('contact', '内容');
            }

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
