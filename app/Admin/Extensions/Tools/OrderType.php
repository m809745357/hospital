<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class OrderType extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['order-type' => '_order-type_']);

        return <<<EOT

$('input:radio.user-order-type').change(function () {

    var url = "$url".replace('_order-type_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = [
            'App\\Models\\Food' => '微信点餐',
            'App\\Models\\Physical' => '单列体检',
            'App\\Models\\Package' => '套餐体检',
            'App\\Models\\Scheduling' => '预约挂号',
        ];

        return view('admin.tools.order-type', compact('options'));
    }
}
