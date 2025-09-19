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
            // Add missing fields that the controller needs
            $table->string('first_name')->nullable()->after('cpr_number');
            $table->string('last_name')->nullable()->after('first_name');
            $table->text('message')->nullable()->after('section');
            $table->text('signature')->nullable()->after('message');
            $table->string('phone')->nullable()->after('last_name');
            $table->string('emergency_contact_phone')->nullable()->after('phone');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('signature');
            $table->timestamp('registered_at')->nullable()->after('status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_profiles', function (Blueprint $table) {
            // Remove the added fields
            $table->dropColumn([
                'first_name',
                'last_name',
                'message',
                'signature',
                'phone',
                'emergency_contact_phone',
                'user_id',
                'status',
                'registered_at'
            ]);
            $table->dropSoftDeletes();
        });
    }
};
