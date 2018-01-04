<?php

namespace App\Admin\Extensions\Actions;

use Encore\Admin\Admin;

class OrderConfirm
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.order-exchange').on('click', function () {

    $.ajax({
        method: 'post',
        url: '/admin/orders/' + $(this).data('id') + '/update',
        data: {
            _token: LA.token,
            status: 4
        },
        success: function() {
            $.pjax.reload('#pjax-container');
            toastr.success('订单已完成');
        }
    });

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a href='javascript:void(0);' class='order-exchange' data-id='{$this->id}'><i class='fa fa-road'></i>完成</a> ";
    }

    public function __toString()
    {
        return $this->render();
    }
}
