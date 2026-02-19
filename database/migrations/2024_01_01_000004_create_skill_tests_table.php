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
        Schema::create('skill_tests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('skill_category'); // programming, design, marketing, etc.
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced', 'expert'])->default('beginner');
            $table->integer('duration_minutes')->default(30);
            $table->json('questions')->nullable();
            $table->integer('passing_score')->default(70);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_tests');
    }
};
