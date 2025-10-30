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
        Schema::table('al_hasalas', function (Blueprint $table) {
            $table->renameColumn('amount', 'monthly_amount');
        });

        Schema::table('al_hasalas', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->after('monthly_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('al_hasalas', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });

        Schema::table('al_hasalas', function (Blueprint $table) {
            $table->renameColumn('monthly_amount', 'amount');
        });
    }
};
