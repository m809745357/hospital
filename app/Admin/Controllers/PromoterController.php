<?php

namespace App\Admin\Controllers;

use App\Models\Promoter;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PromoterController extends Controller
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
            $content->header('转诊管理');
            $content->description('展示转诊管理信息');

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
            $content->header('转诊管理');
            $content->description('展示转诊管理信息');

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
            $content->header('转诊管理');
            $content->description('展示转诊管理信息');

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
        return Admin::grid(Promoter::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->column('user.name', '推广人名称');
            $grid->hospital('推广人医院')->editable();
            $grid->department('推广人部门')->editable();
            $grid->job_title('推广人职称')->editable();
            $grid->crown('皇冠')->editable()->sortable();
            $grid->stars('星星')->editable()->sortable();

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
        return Admin::form(Promoter::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->select('user_id', '用户')->options(function ($value) {
                return \App\User::all()->pluck('name', 'id');
            });
            $form->text('hospital', '医院');
            $form->text('department', '部门');
            $form->text('job_title', '职称');
            $form->number('crown', '皇冠');
            $form->number('stars', '星星');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
