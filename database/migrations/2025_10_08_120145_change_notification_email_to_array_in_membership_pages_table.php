<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert any existing single email to an array format
        $page = DB::table('membership_pages')->first();

        if ($page && $page->notification_email) {
            $emailArray = json_encode([$page->notification_email]);
            DB::table('membership_pages')
                ->where('id', $page->id)
                ->update(['notification_email' => $emailArray]);
        }

        // Change column type to JSON
        Schema::table('membership_pages', function (Blueprint $table) {
            $table->json('notification_email')->nullable()->change();
        });

        // Rename the column
        Schema::table('membership_pages', function (Blueprint $table) {
            $table->renameColumn('notification_email', 'notification_emails');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename back
        Schema::table('membership_pages', function (Blueprint $table) {
            $table->renameColumn('notification_emails', 'notification_email');
        });

        // Convert back to string, taking first email if multiple
        $page = DB::table('membership_pages')->first();

        if ($page && $page->notification_email) {
            $emails = json_decode($page->notification_email, true);
            $firstEmail = is_array($emails) && ! empty($emails) ? $emails[0] : null;

            DB::table('membership_pages')
                ->where('id', $page->id)
                ->update(['notification_email' => $firstEmail]);
        }

        // Change back to string
        Schema::table('membership_pages', function (Blueprint $table) {
            $table->string('notification_email')->nullable()->change();
        });
    }
};
