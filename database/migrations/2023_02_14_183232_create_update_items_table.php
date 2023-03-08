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
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('seller_id','item_seller')->references('id')->on('sellers')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('subcategory_id','subcategory_item')->references('id')->on('sub_categories')->
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
        Schema::table('items', function (Blueprint $table) {

            $table->foreign('seller_id','item_seller')->references('id')->on('sellers')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('subcategory_id','subcategory_item')->references('id')->on('sub_categories')->
                    cascadeOnDelete()->cascadeOnUpdate();
                    
        });
    }
};
