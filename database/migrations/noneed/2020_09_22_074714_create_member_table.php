<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account')->default('');
            $table->string('password')->default('');
            $table->integer('status')->default('1');
            $table->string('realname')->default('1')->nullable();
            $table->string('bankcard')->default('1')->nullable();
            $table->string('banktype')->default('1')->nullable();
            $table->string('bankaddress')->default('1')->nullable();
            $table->decimal('balance')->default('0')->nullable();
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
        Schema::dropIfExists('member');
    }
}
