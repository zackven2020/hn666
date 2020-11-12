<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWanfaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wanfa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('title')->default('');
            $table->decimal('rate');
            $table->decimal('maxodds');
            $table->integer('maxbet');
            $table->decimal('minpay');
            $table->decimal('maxpay');
            $table->longText('note');
            $table->integer('status');
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
        Schema::dropIfExists('wanfa');
    }
}
