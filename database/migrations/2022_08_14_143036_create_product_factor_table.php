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
        Schema::create('product_factor', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->primary();
            $table->integer('sales')->default(0);
            $table->integer('recent_sales')->default(0);
            $table->integer('views')->default(0);
            $table->integer('ratings')->default(0);
            $table->integer('avg_rating')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_factor');
    }
};
