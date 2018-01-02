<?php

namespace App\Admin\Controllers;

use App\Models\Dynamic;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DynamicController extends Controller
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
            $content->header('医院动态');
            $content->description('展示医院动态信息');

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
            $content->header('医院动态');
            $content->description('展示医院动态信息');

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
            $content->header('医院动态');
            $content->description('展示医院动态信息');

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
        return Admin::grid(Dynamic::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->image('图片')->image('/uploads/', 50, 50);
            $grid->title('标题')->limit(30)->editable();
            $grid->desc('描述')->limit(50);
            $grid->click_num('点击量')->editable()->sortable();
            $states = [
                'on' => ['value' => 1, 'text' => '展示', 'color' => 'primary'],
                'off' => ['value' => 2, 'text' => '不展示', 'color' => 'default'],
            ];
            $grid->status('状态')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->where(function ($query) {
                    $query->where('title', 'like', "%{$this->input}%")
                        ->orWhere('desc', 'like', "%{$this->input}%");
                }, '标题或描述');
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
        return Admin::form(Dynamic::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->image('image', '图片')->removable()->crop(325, 213)->help('推荐像素 325 * 213');
            $form->text('title', '标题')->help('最好少于20个字');
            $form->textarea('desc', '描述')->help('最好少于50个字');
            $form->number('click_num', '点击量');
            $form->editor('body', '内容');
            $form->switch('status', '状态')->options([1 => '展示', 2 => '不展示']);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
