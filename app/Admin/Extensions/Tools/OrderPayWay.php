<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class OrderPayWay extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['order-pay-way' => '_order-pay-way_']);

        return <<<EOT

$('input:radio.user-order-pay-way').change(function () {

    var url = "$url".replace('_order-pay-way_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        //'wechat', 'card', 'ipad'
        $options = [
            'wechat' => '微信支付',
            'card' => '一卡通支付',
            'ipad' => 'ipad支付',
        ];

        return view('admin.tools.order-pay-way', compact('options'));
    }
}
