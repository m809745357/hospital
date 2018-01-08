<?php

namespace App\Admin\Extensions\Excels;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Encore\Admin\Facades\Admin;
use App\User;

class UserExport extends AbstractExporter
{
    public function export()
    {
        Excel::create('用户导出', function ($excel) {
            if (Admin::user()->isAdministrator()) {
                $excel->sheet('微信用户', function ($sheet) {
                    // 这段逻辑是从表格数据中取出需要导出的字段
                    $sheet->row(1, ['ID', '头像', '手机号码', '微信OpenID', '姓名', '性别', '身份证', '床位', '角色', '是否认证', '备注', '创建时间']);
                    $rows = User::hydrate($this->getData())->map(function ($item) {
                        return [
                            $item->id,
                            $item->name,
                            $item->avatar,
                            $item->mobile,
                            $item->openid,
                            $this->getGender($item->gender),
                            ' ' . $item->card,
                            $item->address,
                            $item->role === 'normal' ? '普通角色' : '转诊医生',
                            $item->certification === 1 ? '已认证' : '未认证',
                            $item->remark,
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
            0 => '未知',
            1 => '男',
            2 => '女'
        ];
        return $genders[$gender];
    }
}
