<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoterRecordStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promoter_record_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->unsignedInteger('user_id');
            $table->string('crown')->default(0);
            $table->string('stars')->default(0);
            $table->integer('status')->default(0);
            $table->unique(['date', 'user_id']);
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
        Schema::dropIfExists('promoter_record_statistics');
    }
}
