<?php

namespace App\Admin\Controllers;

use App\Models\Physical;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Department;

class PhysicalController extends Controller
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
            $content->header('单列体检');
            $content->description('展示单列体检信息');

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
            $content->header('单列体检');
            $content->description('展示单列体检信息');

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
            $content->header('单列体检');
            $content->description('展示单列体检信息');

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
        return Admin::grid(Physical::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->image('体检图片')->image('/uploads/', 50, 50);
            $grid->title('体检名称')->limit(30)->editable('textarea');
            $grid->desc('体检描述')->limit(50)->editable('textarea');
            $grid->money('体检价格')->editable()->sortable();
            $grid->department_id('体检部门')->select(Department::all()->pluck('name', 'id'));
            $states = [
                'on' => ['value' => 1, 'text' => '上架', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '下架', 'color' => 'default'],
            ];
            $grid->status('状态')->switch($states);

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
        return Admin::form(Physical::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', '体检名称');
            $form->select('department_id', '部门')->options(function ($ids) {
                return Department::find($ids)->pluck('name', 'id');
            });
            $form->image('image', '体检图片')->removable()->crop(200, 200)->help('推荐像素 200 * 200');
            $form->textarea('desc', '体检描述')->help('最好少于50个字');
            $form->number('money', '体检价格');
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
