<?php

namespace App\Admin\Controllers;

use App\Models\Food;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Channel;

class FoodController extends Controller
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
            $content->header('餐品信息');
            $content->description('展示餐品信息列表');

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
            $content->header('餐品信息');
            $content->description('展示餐品信息列表');

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
            $content->header('餐品信息');
            $content->description('展示餐品信息列表');

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
        return Admin::grid(Food::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->image('菜品图片')->image('/uploads/', 50, 50);
            $grid->title('菜品名称')->limit(30)->editable('textarea');
            $grid->desc('菜品描述')->limit(50)->editable('textarea');
            $grid->money('菜品价格')->editable('textarea')->sortable();
            $grid->channel_id('菜品分类')->select(Channel::all()->pluck('name', 'id'));
            $grid->type('菜品时间')->select([
                'am' => '上午',
                'pm' => '下午',
                'all' => '全天',
            ]);

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
                    $query->where('title', 'like', "%{$this->input}%")
                        ->orWhere('desc', 'like', "%{$this->input}%");
                }, '菜品标题或描述');

                $filter->equal('channel_id', '菜品分类')->select(Channel::all()->pluck('name', 'id'));
                $filter->equal('type', '门诊类型')->select([
                    'am' => '上午',
                    'pm' => '下午',
                    'all' => '全天',
                ]);
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
        return Admin::form(Food::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', '菜品名称');
            $form->select('channel_id', '菜品分类')->options(function () {
                return Channel::all()->pluck('name', 'id');
            });

            $form->image('image', '菜品图片')->removable()->crop(200, 200)->help('推荐像素 200 * 200');
            $form->textarea('desc', '菜品描述')->help('最好少于50个字');
            $form->number('money', '菜品价格');
            $form->select('type', '状态')->options([
                'am' => '上午',
                'pm' => '下午',
                'all' => '全天',
            ]);

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
