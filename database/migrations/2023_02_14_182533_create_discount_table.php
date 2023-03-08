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
        Schema::create('discount', function (Blueprint $table) {
           
            $table->increments('id');
            $table->tinyInteger('discount_value');
            $table->date('time_start');
            $table->date('time_end');
            $table->integer('item_id')->unsigned();
            
            $table->foreign('item_id','item_discount')->references('id')->on('items')->
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
        Schema::dropIfExists('discount');
    }
};
