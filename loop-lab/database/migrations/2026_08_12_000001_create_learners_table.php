<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learners', function (Blueprint $table) {
            $table->id();
            $table->uuid('learner_key')->unique();
            $table->string('display_name', 30);
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learners');
    }
};
