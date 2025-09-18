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
        Schema::table('f_a_q_s', function (Blueprint $table) {
            $table->foreignId('faq_category_id')->nullable()->after('answer')->constrained('f_a_q_categories')->nullOnDelete();

            // Add index for better performance
            $table->index(['faq_category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('f_a_q_s', function (Blueprint $table) {
            $table->dropForeign(['faq_category_id']);
            $table->dropIndex(['faq_category_id', 'status']);
            $table->dropColumn('faq_category_id');
        });
    }
};
