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

        Schema::create('shops', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name',50);
            $table->string('address',200);
            $table->integer('post_number')->nullable(false);
            $table->integer('category_id')->unsigned();
            $table->string('city',50);
            $table->string('sended_person_email',150);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('sellerID',15);

            $table->foreign('sellerID','seller_shop')->references('id')->on('sellers')->
                    cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id','shop_catgory')->references('id')->on('categories')->
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
        Schema::dropIfExists('shops');
    }
};
