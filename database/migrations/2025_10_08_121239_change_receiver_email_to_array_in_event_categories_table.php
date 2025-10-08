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
        // Get existing receiver_email values and convert them to arrays
        $categories = DB::table('event_categories')
            ->whereNotNull('receiver_email')
            ->get();

        // Add new JSON column for receiver_emails
        Schema::table('event_categories', function (Blueprint $table) {
            $table->json('receiver_emails')->nullable()->after('receiver_email');
        });

        // Migrate data from receiver_email to receiver_emails
        foreach ($categories as $category) {
            if (! empty($category->receiver_email)) {
                DB::table('event_categories')
                    ->where('id', $category->id)
                    ->update([
                        'receiver_emails' => json_encode([$category->receiver_email]),
                    ]);
            }
        }

        // Drop the old receiver_email column
        Schema::table('event_categories', function (Blueprint $table) {
            $table->dropColumn('receiver_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the old receiver_email column
        Schema::table('event_categories', function (Blueprint $table) {
            $table->string('receiver_email')->nullable()->after('description');
        });

        // Get existing receiver_emails values and convert back
        $categories = DB::table('event_categories')
            ->whereNotNull('receiver_emails')
            ->get();

        // Migrate data from receiver_emails to receiver_email (take first email)
        foreach ($categories as $category) {
            $emails = json_decode($category->receiver_emails, true);
            if (! empty($emails) && is_array($emails)) {
                DB::table('event_categories')
                    ->where('id', $category->id)
                    ->update([
                        'receiver_email' => $emails[0],
                    ]);
            }
        }

        // Drop the receiver_emails column
        Schema::table('event_categories', function (Blueprint $table) {
            $table->dropColumn('receiver_emails');
        });
    }
};
