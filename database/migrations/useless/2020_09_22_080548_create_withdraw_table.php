<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->decimal('money');
            $table->string('before')->default('');
            $table->string('after')->default('');
            $table->string('status')->default('');
            $table->string('operate')->default('');
            $table->string('realname')->default('');
            $table->string('bankcard')->default('');
            $table->string('banktype')->default('');
            $table->string('bankaddress')->default('');
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
        Schema::dropIfExists('withdraw');
    }
}
