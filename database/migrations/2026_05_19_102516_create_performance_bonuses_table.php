<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('bonus_date');
            $table->decimal('daily_volume', 12, 2)->default(0);
            $table->decimal('target_amount', 12, 2)->default(0);
            $table->decimal('bonus_amount', 12, 2)->default(0);
            $table->boolean('target_achieved')->default(false);
            $table->enum('status', ['pending', 'credited'])->default('pending');
            $table->timestamps();
        });

        // Security holds table
        Schema::create('security_holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('reason');
            $table->enum('type', ['deposit', 'withdrawal', 'dispute']);
            $table->enum('status', ['held', 'released', 'forfeited'])->default('held');
            $table->string('reference_id')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_bonuses');
        Schema::dropIfExists('security_holds');
    }
};
