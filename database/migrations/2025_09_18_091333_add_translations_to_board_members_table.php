<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Create temporary columns to store the original data
        Schema::table('board_members', function (Blueprint $table) {
            $table->string('name_backup')->nullable();
            $table->string('position_backup')->nullable();
            $table->text('description_backup')->nullable();
        });

        // Step 2: Copy existing data to backup columns
        DB::statement('UPDATE board_members SET name_backup = name, position_backup = position, description_backup = description');

        // Step 3: Drop original columns
        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn(['name', 'position', 'description']);
        });

        // Step 4: Create new JSON columns
        Schema::table('board_members', function (Blueprint $table) {
            $table->json('name');
            $table->json('position');
            $table->json('description')->nullable();
        });

        // Step 5: Convert and restore data in JSON format
        $boardMembers = DB::table('board_members')->get();
        
        foreach ($boardMembers as $member) {
            DB::table('board_members')
                ->where('id', $member->id)
                ->update([
                    'name' => json_encode([
                        'en' => $member->name_backup,
                        'ar' => $member->name_backup, // Default to same value, update manually later
                    ]),
                    'position' => json_encode([
                        'en' => $member->position_backup,
                        'ar' => $member->position_backup, // Default to same value, update manually later
                    ]),
                    'description' => $member->description_backup ? json_encode([
                        'en' => $member->description_backup,
                        'ar' => $member->description_backup, // Default to same value, update manually later
                    ]) : null,
                ]);
        }

        // Step 6: Drop backup columns
        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn(['name_backup', 'position_backup', 'description_backup']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create temporary columns for the JSON data
        Schema::table('board_members', function (Blueprint $table) {
            $table->text('name_json_backup')->nullable();
            $table->text('position_json_backup')->nullable();
            $table->text('description_json_backup')->nullable();
        });

        // Backup JSON data
        DB::statement('UPDATE board_members SET name_json_backup = name::text, position_json_backup = position::text, description_json_backup = description::text');

        // Drop JSON columns
        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn(['name', 'position', 'description']);
        });

        // Create original string columns
        Schema::table('board_members', function (Blueprint $table) {
            $table->string('name');
            $table->string('position');
            $table->text('description')->nullable();
        });

        // Restore data (extract English version from JSON)
        $boardMembers = DB::table('board_members')->get();
        
        foreach ($boardMembers as $member) {
            $nameData = json_decode($member->name_json_backup, true);
            $positionData = json_decode($member->position_json_backup, true);
            $descriptionData = $member->description_json_backup ? json_decode($member->description_json_backup, true) : null;

            DB::table('board_members')
                ->where('id', $member->id)
                ->update([
                    'name' => $nameData['en'] ?? $nameData['ar'] ?? '',
                    'position' => $positionData['en'] ?? $positionData['ar'] ?? '',
                    'description' => $descriptionData ? ($descriptionData['en'] ?? $descriptionData['ar'] ?? null) : null,
                ]);
        }

        // Drop backup columns
        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn(['name_json_backup', 'position_json_backup', 'description_json_backup']);
        });
    }
};
