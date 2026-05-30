<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->decimal('usdt_amount', 12, 6)->nullable()->after('amount');
            $table->decimal('usdt_rate_at_time', 10, 2)->nullable()->after('usdt_amount');
            $table->enum('payment_type', ['upi', 'usdt'])->default('upi')->after('usdt_rate_at_time');
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn(['usdt_amount', 'usdt_rate_at_time', 'payment_type']);
        });
    }
};
