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
        Schema::create('customers_sellers', function (Blueprint $table) {

            $table->integer('userID')->unsigned();
            $table->string('sellerID',15);
            
            $table->foreign('userID')->references('id')->on('users')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('sellerID')->references('id')->on('sellers')->
                    cascadeOnDelete()->cascadeOnUpdate();

            $table->primary(['userID','sellerID']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_sellers');
    }
};
