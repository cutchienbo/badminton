<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->foreign('id_type')->references('id')->on('type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('id_yard')->references('id')->on('yard');
        });

        Schema::table('order_product', function (Blueprint $table) {
            $table->foreign('id_order')->references('id')->on('orders');

            $table->foreign('id_product')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foreign_key');
    }
};
