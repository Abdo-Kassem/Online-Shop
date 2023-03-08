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
        Schema::create('feedbacks', function (Blueprint $table) {

            $table->integer('userID')->unsigned();
            $table->integer('itemID')->unsigned();
            $table->tinyInteger('feedback')->default(0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('userID')->references('id')->on('users')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('itemID')->references('id')->on('items')->
                    cascadeOnDelete()->cascadeOnUpdate();

            $table->primary(['userID','itemID']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
};
