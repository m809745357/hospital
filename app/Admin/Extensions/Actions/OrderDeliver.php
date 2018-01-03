<?php

namespace App\Admin\Extensions\Actions;

use Encore\Admin\Admin;
use Illuminate\Support\Facades\Request;

class OrderDeliver
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.order-deliver').on('click', function () {

    $.ajax({
        method: 'post',
        url: '/admin/orders/' + $(this).data('id') + '/update',
        data: {
            _token: LA.token,
            status: 3
        },
        success: function() {
            $.pjax.reload('#pjax-container');
            toastr.success('发货成功');
        }
    });

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a href='javascript:void(0);' class='order-deliver' data-id='{$this->id}'><i class='fa fa-send'></i>配送</a> ";
    }

    public function __toString()
    {
        return $this->render();
    }
}
