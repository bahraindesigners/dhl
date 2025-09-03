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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();

            // Event and user relationship
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Registration details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('special_requirements')->nullable();

            // Registration status
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'attended'])->default('pending');
            $table->timestamp('registered_at');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // Payment information
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->enum('payment_status', ['pending', 'paid', 'refunded', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();

            // Additional data
            $table->json('registration_data')->nullable(); // Custom form fields
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            // Indexes and constraints
            $table->unique(['event_id', 'email']); // Prevent duplicate registrations
            $table->index(['event_id', 'status']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
