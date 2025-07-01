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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->string('first_name');
            $table->string('infix')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('person_type');
            $table->boolean('is_representative')->default(false);
            $table->timestamps();
            $table->text('comment')->nullable();
            $table->boolean('isactive')->default(true);
            $table->timestamp('dateadded')->useCurrent();
            $table->timestamp('datechanged')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
