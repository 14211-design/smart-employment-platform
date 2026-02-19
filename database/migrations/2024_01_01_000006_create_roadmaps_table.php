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
        Schema::create('roadmaps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('career_path'); // software-engineer, designer, marketer, etc.
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->json('milestones')->nullable(); // Array of learning milestones
            $table->json('resources')->nullable(); // Array of learning resources
            $table->integer('estimated_duration_weeks')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmaps');
    }
};
