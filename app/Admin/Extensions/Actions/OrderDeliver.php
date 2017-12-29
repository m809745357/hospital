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
        $url = Request::fullUrl();

        return <<<SCRIPT

$('.order-deliver').on('click', function () {

    // Your code.
    console.log($(this).data('id'));

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a href='javascript:void(0);' class='order-deliver' data-id='{$this->id}'><i class='fa fa-send'></i></a> ";
    }

    public function __toString()
    {
        return $this->render();
    }
}
