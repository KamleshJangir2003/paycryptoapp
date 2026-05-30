<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('withdrawals', 'proof_screenshot')) {
            Schema::table('withdrawals', function (Blueprint $table) {
                $table->string('proof_screenshot')->nullable()->after('utr_number');
            });
        }
    }

    public function down(): void
    {
        //
    }
};
