<?php

namespace App\Admin\Controllers;

use App\Models\Promoter;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\AdminUser;

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
            if (Admin::user()->isRole('promoter')) {
                $grid->model()->where('admin_user_id', Admin::user()->id);
            }

            $grid->column('user.name', '推广人名称');
            $grid->hospital('推广人医院')->editable();
            $grid->department('推广人部门')->editable();
            $grid->job_title('推广人职称')->editable();
            $grid->crown('皇冠')->editable()->sortable();
            $grid->stars('星星')->editable()->sortable();
            $grid->column('admin_user.name', '管理员名称');

            $states = [
                'on' => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
            ];
            $grid->status('状态')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');

            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->where(function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '推广人名称');

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
        return Admin::form(Promoter::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->select('user_id', '用户')->options(function ($user_id) {
                if ($user_id) {
                    $user = \App\User::find($user_id);
                    return [
                        $user_id => "姓名：{$user->name} 手机：{$user->mobile}"
                    ];
                }
                return \App\User::with('promoter')->get()->map(function ($item) use ($user_id) {
                    if ($item->promoter == null || $user_id === $item->id) {
                        $item->value = "姓名：{$item->name} 手机：{$item->mobile}";
                        return $item;
                    }
                })->pluck('value', 'id');
            });
            $form->text('hospital', '医院');
            $form->text('department', '部门');
            $form->text('job_title', '职称');
            // $form->number('crown', '皇冠');
            // $form->number('stars', '星星');

            $states = [
                'on' => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
            ];

            $form->switch('status', '状态')->states($states);

            if (Admin::user()->isAdministrator()) {
                $form->select('admin_user_id', '推广员')->options(function ($value) {
                    return AdminUser::all()->pluck('name', 'id');
                });
                $form->saving(function (Form $form) {
                    \App\User::find($form->user_id)->update(['role' => 'promoter']);
                });
            } else {
                $form->hidden('admin_user_id');

                $form->saving(function (Form $form) {
                    $form->admin_user_id = Admin::user()->id;
                    \App\User::find($form->user_id)->update(['role' => 'promoter']);
                });
            }

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
