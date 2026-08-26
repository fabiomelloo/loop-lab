<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reward_items', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('description');
            $table->string('category');
            $table->unsignedInteger('cost');
            $table->string('accent')->default('blue');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('reward_redemptions', function (Blueprint $table) {
            $table->id();
            $table->string('learner_key');
            $table->foreignId('reward_item_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('points_spent');
            $table->string('redemption_code')->unique();
            $table->timestamp('redeemed_at');
            $table->timestamps();
            $table->unique(['learner_key', 'reward_item_id']);
            $table->index(['learner_key', 'redeemed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward_redemptions');
        Schema::dropIfExists('reward_items');
    }
};
