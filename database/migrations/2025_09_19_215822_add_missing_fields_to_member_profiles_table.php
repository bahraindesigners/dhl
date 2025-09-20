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
        Schema::table('member_profiles', function (Blueprint $table) {
            // Add only the missing fields (user_id and other fields already exist)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('registered_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_profiles', function (Blueprint $table) {
            $table->dropColumn(['status', 'registered_at']);
        });
    }
};
