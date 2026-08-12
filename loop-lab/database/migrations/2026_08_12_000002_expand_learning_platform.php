<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->foreignId('prerequisite_lesson_id')->nullable()->after('module_id')->constrained('lessons')->nullOnDelete();
        });
        Schema::table('exercises', function (Blueprint $table) {
            $table->string('type')->default('code')->after('difficulty');
            $table->json('options')->nullable()->after('hints');
            $table->string('correct_answer')->nullable()->after('options');
        });
        Schema::table('learners', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
        Schema::table('exercise_attempts', function (Blueprint $table) {
            $table->text('diagnostic')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('exercise_attempts', fn (Blueprint $table) => $table->dropColumn('diagnostic'));
        Schema::table('learners', fn (Blueprint $table) => $table->dropConstrainedForeignId('user_id'));
        Schema::table('exercises', fn (Blueprint $table) => $table->dropColumn(['type', 'options', 'correct_answer']));
        Schema::table('lessons', fn (Blueprint $table) => $table->dropConstrainedForeignId('prerequisite_lesson_id'));
    }
};
