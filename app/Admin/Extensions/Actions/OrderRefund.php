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

    // Your code.
    console.log($(this).data('id'));

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a href='javascript:void(0);' class='order-refund' data-id='{$this->id}'><i class='fa fa-money'></i> </a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
