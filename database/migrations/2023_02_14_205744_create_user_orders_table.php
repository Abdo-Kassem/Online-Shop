<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {

            $table->increments('id');
            $table->decimal('price');
            $table->boolean('state')->default(false);
            $table->dateTime('sendTime');
            $table->integer('userID')->unsigned();

            $table->foreign('userID','user_order')->references('id')->on('users')->
                    cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_orders');
    }
};
