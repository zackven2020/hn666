<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default('0')->comment('上級代理');
            $table->integer('order')->default('0')->comment('0');
            $table->string('title')->default('')->comment('代号');
            $table->string('name')->nullable()->comment('名字');
            $table->integer('level')->default('0')->nullable()->comment('等级');
            $table->integer('status')->default('0')->nullable()->comment('状态');
            $table->integer('rabate')->default('0')->nullable()->comment('返利比例%');
            $table->decimal('balance')->nullable()->comment('余额(元)');
            $table->string('invate_url')->nullable()->comment('邀请码');
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
        Schema::dropIfExists('agent');
    }
}
