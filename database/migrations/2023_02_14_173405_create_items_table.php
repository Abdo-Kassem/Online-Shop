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

        Schema::create('items', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name',50);
            $table->text('details');
            $table->string('image',100);
            $table->decimal('price')->unsigned();
            $table->mediumInteger('item_number')->comment('stor number of item exist')->default(1);
            $table->string('seller_id',15);
            $table->boolean('free_shipping')->comment('do free shipping or no boolean value')->default(true);
            $table->integer('shipping_cost')->comment('cost of shipping')->default(0);
            $table->integer('subcategory_id')->unsigned();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
