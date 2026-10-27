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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('price', places: 2);
            $table->integer('currency_id');
            $table->decimal('tax_cost', places: 2);
            $table->decimal('manufacturing_cost', places: 2);
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('currency_id')->references('id')->on('divisas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
