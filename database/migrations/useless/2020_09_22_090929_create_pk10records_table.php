<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePk10recordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pk10records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->default('');
            $table->string('term')->default('');
            $table->decimal('before');
            $table->decimal('after');
            $table->decimal('lotterymoney');
            $table->decimal('maxamount');
            $table->decimal('afterlottery');
            $table->integer('status')->comment('0待開1已開,2流開');
            $table->decimal('finaly');
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
        Schema::dropIfExists('pk10records');
    }
}
