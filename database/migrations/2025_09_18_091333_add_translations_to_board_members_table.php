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
        Schema::table('board_members', function (Blueprint $table) {
            // Convert translatable fields to JSON
            $table->json('name')->change();
            $table->json('position')->change();
            $table->json('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_members', function (Blueprint $table) {
            // Revert to text fields
            $table->string('name')->change();
            $table->string('position')->change();
            $table->text('description')->nullable()->change();
        });
    }
};
