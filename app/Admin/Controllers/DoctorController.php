<?php

namespace App\Admin\Controllers;

use App\Models\Doctor;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Department;

class DoctorController extends Controller
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
            $content->header('医生信息');
            $content->description('展示医生信息列表');

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
            $content->header('医生信息');
            $content->description('展示医生信息列表');

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
            $content->header('医生信息');
            $content->description('展示医生信息列表');

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
        return Admin::grid(Doctor::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->image('图片')->image('/uploads/', 50, 50);
            $grid->name('姓名')->editable();
            $grid->title('职称')->editable();
            $grid->recep_num('诊断次数')->editable()->sortable();
            $grid->desc('擅长')->editable('textarea');
            $grid->department_id('部门')->select(Department::all()->pluck('name', 'id'));
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
                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('title', 'like', "%{$this->input}%")
                        ->orWhere('desc', 'like', "%{$this->input}%");
                }, '关键字');
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
        return Admin::form(Doctor::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('name', '姓名');
            $form->image('image', '头像')->removable()->crop(200, 200)->help('推荐像素 200 * 200');
            $form->text('title', '职称')->help('最好少于10个字');
            $form->number('recep_num', '诊断次数');
            $form->textarea('desc', '擅长')->help('最好少于50个字');
            $form->select('department_id', '部门')->options(function () {
                return Department::all()->pluck('name', 'id');
            });

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
