<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamelistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamelist', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->integer('status');
            $table->decimal('maxodds');
            $table->decimal('maxamount');
            $table->integer('show');
            $table->integer('sort');
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
        Schema::dropIfExists('gamelist');
    }
}
