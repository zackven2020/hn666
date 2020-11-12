<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePk10historyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pk10history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('n1')->default('');
            $table->string('n2')->default('');
            $table->string('n3')->default('');
            $table->string('n4')->default('');
            $table->string('n5')->default('');
            $table->string('n6')->default('');
            $table->string('n7')->default('');
            $table->string('n8')->default('');
            $table->string('n9')->default('');
            $table->string('n10')->default('');
            $table->string('term')->default('');
            $table->string('term_time')->default('');
            $table->string('number')->default('');
            $table->string('from')->default('');
            $table->string('elapsed')->default('');
            $table->string('sum')->default('');
            $table->string('daxiao')->default('');
            $table->string('danshuang')->default('');
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
        Schema::dropIfExists('pk10history');
    }
}
