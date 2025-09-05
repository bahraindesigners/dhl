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
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();

            // Identification & Basic Info
            $table->string('cpr_number', 9)->unique()->comment('Exactly 9 digits');
            $table->string('staff_number', 20)->unique();
            $table->string('full_name');
            $table->string('nationality', 100);
            $table->enum('gender', ['male', 'female']);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widow']);
            $table->string('email')->nullable();

            // Work Information
            $table->date('date_of_joining');
            $table->string('position');
            $table->string('department');
            $table->string('section')->nullable();
            $table->text('working_place_address');
            $table->string('office_phone', 20)->nullable();

            // Education & Qualifications
            $table->string('education_qualification');

            // Contact Information
            $table->string('mobile_number', 20);
            $table->string('home_phone', 20)->nullable();
            $table->text('permanent_address');

            // Status
            $table->boolean('profile_status')->default(true);

            // Indexes for better performance
            $table->index(['department', 'profile_status']);
            $table->index(['gender', 'marital_status']);
            $table->index('date_of_joining');
            $table->index('staff_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_profiles');
    }
};
