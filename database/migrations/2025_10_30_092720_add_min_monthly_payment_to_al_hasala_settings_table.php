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
        Schema::table('al_hasala_settings', function (Blueprint $table) {
            $table->decimal('min_monthly_payment', 8, 2)->default(50.00)->after('max_months');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('al_hasala_settings', function (Blueprint $table) {
            $table->dropColumn('min_monthly_payment');
        });
    }
};
