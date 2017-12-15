<?php

namespace App\Admin\Controllers;

use App\Models\Scheduling;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Doctor;

class SchedulingController extends Controller
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
            $content->header('门诊排班');
            $content->description('展示门诊排班信息');

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
            $content->header('门诊排班');
            $content->description('展示门诊排班信息');

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
            $content->header('门诊排班');
            $content->description('展示门诊排班信息');

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
        return Admin::grid(Scheduling::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->doctor()->name('医生');
            $grid->type('状态');
            $grid->day('星期')->display(function ($day) {
                $days = ['星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日'];
                return $days[$day - 1];
            });
            $grid->time('上下午')->display(function ($time) {
                $times = ['上午', '下午', '全天'];
                return $times[$time - 1];
            });
            $grid->address('地址');
            $grid->money('门诊费');

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
        return Admin::form(Scheduling::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->select('doctor_id', '医生')->options(function ($ids) {
                return Doctor::find($ids)->pluck('name', 'id');
            });
            $form->text('address', '地址');
            $form->number('money', '门诊费');
            $form->select('day', '星期')->options([
                1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六', 0 => '星期日'
            ]);
            $form->select('time', '上下午')->options([
                1 => '上午', 2 => '下午', 3 => '全天'
            ]);
            $form->select('type', '状态')->options(Scheduling::TYPES_DISPLAY);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
