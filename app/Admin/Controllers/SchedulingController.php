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
use Illuminate\Support\Facades\Request;
use App\Admin\Extensions\Tools\SchedulingDay;
use App\Admin\Extensions\Tools\SchedulingTime;

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

            $grid->doctor()->name('医生')->editable();
            $grid->type('预约类型')->select([
                'expert' => '专家门诊',
                'general' => '普通门诊',
                'famous' => '名医门诊',
            ]);
            $grid->day('星期')->select(['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六']);
            $grid->time('上下午')->select([
                '1' => '上午',
                '2' => '下午',
                '3' => '全天',
            ]);

            $grid->address('地址')->editable();
            $grid->money('门诊费（元）')->editable()->sortable();

            $states = [
                'on' => ['value' => 1, 'text' => '开设', 'color' => 'primary'],
                'off' => ['value' => 2, 'text' => '不开设', 'color' => 'default'],
            ];
            $grid->status('开设状态')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            $grid->tools(function ($tools) {
                $tools->append(new SchedulingDay());
                $tools->append(new SchedulingTime());
            });

            if (in_array(Request::get('scheduling-day'), ['0', '1', '2', '3', '4', '5', '6'])) {
                $grid->model()->where('day', Request::get('scheduling-day'));
            }

            if (in_array(Request::get('scheduling-time'), ['1', '2', '3'])) {
                $grid->model()->where('time', Request::get('scheduling-time'));
            }
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
                0 => '星期日', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六'
            ]);
            $form->select('time', '上下午')->options([
                1 => '上午', 2 => '下午', 3 => '全天'
            ]);
            $form->select('type', '门诊类型')->options(Scheduling::TYPES_DISPLAY);

            $form->switch('status', '开设状态')->options([1 => '开设', 2 => '不开设']);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
