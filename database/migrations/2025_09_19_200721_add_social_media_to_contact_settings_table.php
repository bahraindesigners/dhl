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
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->string('instagram_url')->nullable()->after('notification_email');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('x_url')->nullable()->after('linkedin_url');
        });
    }

    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn(['instagram_url', 'linkedin_url', 'x_url']);
        });
    }
};
