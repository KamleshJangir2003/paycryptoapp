<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('upi_id')->nullable();
            $table->string('upi_name')->nullable();
            $table->string('qr_image')->nullable();
            $table->string('wallet_address')->nullable();
            $table->string('wallet_name')->nullable();
            $table->string('wallet_qr')->nullable();
            $table->boolean('upi_active')->default(true);
            $table->boolean('wallet_active')->default(false);
            $table->text('deposit_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
