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
        Schema::create('product_sort', function (Blueprint $table) {
            $table->unsignedBigInteger('product_rank')->autoIncrement();
            $table->unsignedBigInteger('popular_id')->nullable();
            $table->unsignedBigInteger('best_seller_id')->nullable();
            $table->unsignedBigInteger('high_price_id')->nullable();
            $table->unsignedBigInteger('low_price_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('product_sort');
    }
};
