<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BannerController extends Controller
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
            $content->header('滚动图');
            $content->description('展示滚动图列表信息');

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
            $content->header('滚动图');
            $content->description('展示滚动图列表信息');

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
            $content->header('滚动图');
            $content->description('展示滚动图列表信息');

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
        return Admin::grid(Banner::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->title('标题')->limit(30)->editable('textarea');
            // $grid->image('图片')->image(960, 305);
            $grid->url('链接')->editable('textarea');
            $states = [
                'on' => ['value' => 1, 'text' => '展示', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '不展示', 'color' => 'default'],
            ];
            $grid->status('状态')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');

            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('title', '标题');
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
        return Admin::form(Banner::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', '标题');
            $form->image('image', '图片')->removable()->crop(1920, 610)->help('推荐像素 1920 * 610');
            $form->url('url', '链接');

            $states = [
                'on' => ['value' => 1, 'text' => '展示', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '不展示', 'color' => 'default'],
            ];

            $form->switch('status', '状态')->states($states);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
