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
        Schema::create('product_per_food_packages', function (Blueprint $table) {
            $table->id();
            // Remove foreign keys for now, just use unsignedBigInteger
            $table->unsignedBigInteger('food_package_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity_units');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_per_food_packages');
    }
};
