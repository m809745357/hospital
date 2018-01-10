<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\PromoterRecord;
use App\Models\PromoterOrder;
use App\Models\PromoterRecordStatistics;

class PromoterRecordController extends Controller
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
            $content->header('推广记录');
            $content->description('展示推广记录信息');

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
            $content->header('推广记录');
            $content->description('展示推广记录信息');

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
            $content->header('推广记录');
            $content->description('展示推广记录信息');

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
        return Admin::grid(PromoterRecord::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->model()->with('order.promoter.user', 'order.promoter.admin_user');
            if (Admin::user()->isRole('promoter')) {
                $grid->model()->whereHas('order', function ($query) {
                    $query->whereHas('promoter', function ($query) {
                        $query->where('admin_user_id', Admin::user()->id);
                    });
                });
            }

            $adminUser = \App\Models\AdminUser::all()->pluck('name', 'id');

            $grid->column('order.promoter', '业务员/转诊医生')->display(function ($promoter) use ($adminUser) {
                return ($adminUser[$promoter['admin_user_id']] ?? '暂无推荐人') . '/' . $promoter['user']['name'];
            });

            $grid->column('order.order_no', '转诊订单编号');

            $grid->crown('皇冠');
            $grid->stars('星星');
            $grid->status('是否发奖')->display(function ($stauts) {
                $statuses = [
                    0 => '未发奖',
                    1 => '已发奖'
                ];
                return $statuses[$stauts];
            })->label();

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');

            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器

                $filter->where(function ($query) {
                    $query->whereHas('order', function ($query) {
                        $query->where('order_no', 'like', "%{$this->input}%")
                                ->orWhere('order_no', 'like', "%{$this->input}%");
                    });
                }, '转诊订单编号');

                $filter->between('created_at', '兑换时间')->datetime();
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
        return Admin::form(PromoterRecord::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->select('promoter_order_id', '转诊订单编号')->options(function ($promoter_order_id) {
                if ($promoter_order_id) {
                    $promoterOrder = PromoterOrder::find($promoter_order_id);
                    return [
                        $promoter_order_id => "姓名：{$promoterOrder->name} 单号：{$promoterOrder->order_no}"
                    ];
                }
                return PromoterOrder::with('record')->get()->map(function ($item) use ($promoter_order_id) {
                    if ($item->record == null || $promoter_order_id === $item->id) {
                        $item->value = "姓名：{$item->name} 单号：{$item->mobile}";
                        return $item;
                    }
                })->pluck('value', 'id');
            });

            $form->number('crown', '皇冠');
            $form->number('stars', '星星');
            $form->select('status', '状态')->options([
                0 => '未发奖',
                1 => '已发奖'
            ]);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            $form->saving(function (Form $form) {
                if ($form->model()->order()->exists()) {
                    $form->model()->order->promoter->decrement('crown', $form->model()->crown);
                    $form->model()->order->promoter->decrement('stars', $form->model()->stars);
                    $date = substr($form->model()->created_at, 0, 7);
                    $user_id = $form->model()->order->promoter->user_id;
                    if (PromoterRecordStatistics::where(['date' => $date, 'user_id' => $user_id])->exists()) {
                        $statistics = PromoterRecordStatistics::where(['date' => $date, 'user_id' => $user_id])->first();
                    } else {
                        $statistics = PromoterRecordStatistics::create(['date' => $date, 'user_id' => $user_id]);
                    }
                    $statistics->where('date', $date)->decrement('crown', $form->model()->crown);
                    $statistics->where('date', $date)->decrement('stars', $form->model()->stars);
                }
            });
            $form->saved(function (Form $form) {
                $form->model()->order->promoter->increment('crown', $form->model()->crown);
                $form->model()->order->promoter->increment('stars', $form->model()->stars);
                $date = substr($form->model()->created_at, 0, 7);
                $user_id = $form->model()->order->promoter->user_id;

                if (PromoterRecordStatistics::where(['date' => $date, 'user_id' => $user_id])->exists()) {
                    $statistics = PromoterRecordStatistics::where(['date' => $date, 'user_id' => $user_id])->first();
                } else {
                    $statistics = PromoterRecordStatistics::create(['date' => $date, 'user_id' => $user_id]);
                }
                $statistics->where('date', $date)->increment('crown', $form->model()->crown);
                $statistics->where('date', $date)->increment('stars', $form->model()->stars);
            });
        });
    }
}
