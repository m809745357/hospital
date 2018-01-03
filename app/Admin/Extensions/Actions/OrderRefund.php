<?php

namespace App\Admin\Extensions\Actions;

use Encore\Admin\Admin;

class OrderRefund
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.order-refund').on('click', function () {

    $.ajax({
        method: 'post',
        url: '/admin/orders/' + $(this).data('id') + '/update',
        data: {
            _token: LA.token,
            status: 6
        },
        success: function() {
            $.pjax.reload('#pjax-container');
            toastr.success('退款成功');
        }
    });

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a href='javascript:void(0);' class='order-refund' data-id='{$this->id}'><i class='fa fa-money'></i>退款</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
