<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class OrderStatus extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['order-status' => '_order-status_']);

        return <<<EOT

$('input:radio.user-order-status').change(function () {

    var url = "$url".replace('_order-status_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        //未支付，已支付，已配送/已兑换，已完成，已取消
        $options = [
            '1' => '未支付',
            '2' => '已支付',
            '3' => '已配送/已兑换',
            '4' => '已完成',
            '5' => '已取消',
        ];

        return view('admin.tools.order-status', compact('options'));
    }
}
