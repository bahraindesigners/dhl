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
        Schema::table('downloads', function (Blueprint $table) {
            $table->foreignId('download_category_id')->nullable()->constrained('download_categories')->onDelete('set null');
            $table->index('download_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->dropForeign(['download_category_id']);
            $table->dropIndex(['download_category_id']);
            $table->dropColumn('download_category_id');
        });
    }
};
