<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Order;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('order_details');
            $table->string('order_details_type');
            $table->string('money');
            $table->string('out_trade_no');
            $table->string('remark')->nullable();
            $table->string('order_time');
            $table->enum('status', Order::STATUS)->default(Order::STATUS[0]);
            $table->enum('pay_way', Order::PAY_WAYS)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
