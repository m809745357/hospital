<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class SchedulingTime extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['scheduling-time' => '_scheduling-time_']);

        return <<<EOT

$('input:radio.user-scheduling-time').change(function () {

    var url = "$url".replace('_scheduling-time_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        //未支付，已支付，已配送/已兑换，已完成，已取消
        $options = [
            1 => '上午', 2 => '下午', 3 => '全天'
        ];

        return view('admin.tools.scheduling-time', compact('options'));
    }
}
