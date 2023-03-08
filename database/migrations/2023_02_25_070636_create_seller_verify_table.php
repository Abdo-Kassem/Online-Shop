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
        Schema::create('seller_verify', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seller_id',15);
            $table->string('token',70);
            $table->timestamps();
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
        Schema::dropIfExists('seller_verify');
    }
};
