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
        Schema::table('union_loan_settings', function (Blueprint $table) {
            $table->decimal('min_amount', 10, 2)->default(100.00)->after('max_months');
            $table->decimal('max_amount', 10, 2)->default(10000.00)->after('min_amount');
            $table->decimal('min_monthly_payment', 8, 2)->default(75.00)->after('max_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('union_loan_settings', function (Blueprint $table) {
            $table->dropColumn(['min_amount', 'max_amount', 'min_monthly_payment']);
        });
    }
};
