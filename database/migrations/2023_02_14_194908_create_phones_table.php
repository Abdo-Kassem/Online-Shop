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
        Schema::create('phones', function (Blueprint $table) {

            $table->increments('id');
            $table->string('phone_number',11);
            $table->boolean('is_wallet')->default(false);
            $table->enum('wallet_approach',['fawry','we','vodafone'])->nullable();
            $table->string('seller_id',15);

            $table->foreign('seller_id')->references('id')->on('sellers')->
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
        Schema::dropIfExists('phones');
    }
};
