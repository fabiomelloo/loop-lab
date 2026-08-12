<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedInteger('position');
            $table->boolean('is_available')->default(false);
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary');
            $table->json('content');
            $table->unsignedInteger('position');
            $table->timestamps();
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('difficulty');
            $table->text('description');
            $table->json('rules');
            $table->text('starter_code');
            $table->text('solution');
            $table->text('explanation');
            $table->string('required_structure')->nullable();
            $table->json('hints');
            $table->unsignedInteger('position');
            $table->unsignedInteger('xp')->default(50);
            $table->timestamps();
        });

        Schema::create('exercise_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->text('input')->nullable();
            $table->text('expected_output');
            $table->boolean('is_hidden')->default(true);
            $table->timestamps();
        });

        Schema::create('exercise_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('learner_key')->index();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->longText('code');
            $table->text('output')->nullable();
            $table->string('status');
            $table->unsignedInteger('execution_time')->default(0);
            $table->timestamps();
        });

        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->string('learner_key')->index();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->timestamp('completed_at');
            $table->unsignedInteger('xp');
            $table->timestamps();
            $table->unique(['learner_key', 'exercise_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
        Schema::dropIfExists('exercise_attempts');
        Schema::dropIfExists('exercise_tests');
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('modules');
    }
};
