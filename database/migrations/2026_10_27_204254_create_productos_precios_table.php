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
        Schema::create('productos_precios', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('currency_id');
            $table->decimal('price', places: 2);
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('product_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('divisas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_precios');
    }
};
