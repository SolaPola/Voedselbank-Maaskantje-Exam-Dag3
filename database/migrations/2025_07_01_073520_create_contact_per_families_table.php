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
        Schema::create('contact_per_families', function (Blueprint $table) {
            $table->id();
            // Remove foreign keys for now, just use unsignedBigInteger
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('contact_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_per_families');
    }
};
