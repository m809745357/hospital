<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class SchedulingDay extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['scheduling-day' => '_scheduling-day_']);

        return <<<EOT

$('input:radio.user-scheduling-day').change(function () {

    var url = "$url".replace('_scheduling-day_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        //未支付，已支付，已配送/已兑换，已完成，已取消
        $options = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];

        return view('admin.tools.scheduling-day', compact('options'));
    }
}
