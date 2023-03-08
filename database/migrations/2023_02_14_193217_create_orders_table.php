<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('orders', function (Blueprint $table) {

            $table->increments('id');
            $table->decimal('price')->unsigned();
            $table->boolean('state')->default(false);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('send_time')->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('sellerID',15);
            
            $table->foreign('user_id')->references('id')->on('users')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('sellerID')->references('id')->on('sellers')->
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
        Schema::dropIfExists('orders');
    }
};
