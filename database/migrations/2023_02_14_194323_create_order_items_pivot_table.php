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
        Schema::create('order_items_pivot', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->tinyInteger('item_count')->default(1);
           
            $table->foreign('order_id')->references('id')->on('orders')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('item_id')->references('id')->on('items')->
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
        Schema::dropIfExists('order_items_pivot');
    }
};
