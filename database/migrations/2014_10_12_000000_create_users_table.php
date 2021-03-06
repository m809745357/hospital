<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('openid')->unique();
            $table->string('avatar')->nullable();
            $table->integer('gender')->nullable();
            $table->string('mobile')->nullable();
            $table->string('card')->nullable();
            $table->string('address')->nullable();
            $table->text('remark')->nullable();
            $table->integer('certification')->default(0);
            $table->enum('role', User::ROLES)->default('normal');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
