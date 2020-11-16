<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('type')->default('');
            $table->decimal('money');
            $table->decimal('before');
            $table->decimal('after');
            $table->integer('status')->default('0')->comment('0待處理1儲值成功2儲值失敗');
            $table->integer('operate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit');
    }
}
