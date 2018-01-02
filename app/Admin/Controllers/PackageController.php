<?php

namespace App\Admin\Controllers;

use App\Models\Package;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PackageController extends Controller
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
            $content->header('套餐体检');
            $content->description('展示套餐体检信息展示');

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
            $content->header('套餐体检');
            $content->description('展示套餐体检信息展示');

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
            $content->header('套餐体检');
            $content->description('展示套餐体检信息展示');

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
        return Admin::grid(Package::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->image('体检图片')->image('/uploads/', 50, 50);
            $grid->title('体检名称')->limit(30)->editable('textarea');
            $grid->men_money('男性价格')->editable()->sortable();
            $grid->women_money('女性价格')->editable()->sortable();
            $states = [
                'on' => ['value' => 1, 'text' => '上架', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '下架', 'color' => 'default'],
            ];
            $grid->status('状态')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器

                $filter->where(function ($query) {
                    $query->where('title', 'like', "%{$this->input}%");
                }, '体检名称');
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
        return Admin::form(Package::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', '体检名称');
            $form->image('image', '体检图片')->removable()->crop(200, 200)->help('推荐像素 200 * 200');
            $form->editor('body', '体检描述')->help('图文描述');
            $form->number('men_money');
            $form->number('women_money');
            $states = [
                'on' => ['value' => 1, 'text' => '上架', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '下架', 'color' => 'default'],
            ];

            $form->switch('status', '状态')->states($states);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
