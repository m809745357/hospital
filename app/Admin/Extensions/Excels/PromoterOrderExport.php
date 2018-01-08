<?php

namespace App\Admin\Extensions\Excels;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Encore\Admin\Facades\Admin;
use App\Models\PromoterOrder;

class PromoterOrderExport extends AbstractExporter
{
    public function export()
    {
        Excel::create('转诊订单', function ($excel) {
            if (Admin::user()->isAdministrator() || Admin::user()->isRole('promoter')) {
                $excel->sheet('转诊订单', function ($sheet) {
                    // 这段逻辑是从表格数据中取出需要导出的字段
                    $sheet->row(1, ['ID', '订单编号', '部门', '推广人', '姓名', '性别', '手机号码', '是否兑换', '创建时间']);
                    $rows = PromoterOrder::hydrate($this->getData())->map(function ($item) {
                        return [
                            $item->id,
                            ' ' . $item->order_no,
                            $item->department->name,
                            $item->promoter->user->name,
                            $item->name,
                            $this->getGender($item->gender),
                            $item->mobile,
                            $item->status === '1' ? '已兑换' : '未兑换',
                            $item->created_at
                        ];
                    });
                    $sheet->rows($rows);
                });
            }
        })->export('xls');
    }

    public function getGender($gender)
    {
        $genders = [
            'men' => '男',
            'women' => '女'
        ];
        return $genders[$gender];
    }
}
