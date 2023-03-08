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
        Schema::create('user_item_cart_pivot', function (Blueprint $table) {

            $table->integer('user_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->tinyInteger('item_count')->unsigned()->comment('store number of item ');

            $table->foreign('user_id','user_cart')->references('id')->on('users')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('item_id','item_cart')->references('id')->on('items')->
                    cascadeOnDelete()->cascadeOnUpdate();

            $table->primary(['user_id','item_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_item_cart_pivot');
    }
};
