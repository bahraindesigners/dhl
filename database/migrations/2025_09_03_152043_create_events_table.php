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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Event basic information
            $table->json('title'); // Translatable title
            $table->json('slug'); // Translatable slug
            $table->json('description')->nullable(); // Short description
            $table->json('content'); // Rich text content (translatable)

            // Event scheduling
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('timezone')->default('UTC');

            // Event management
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->boolean('featured')->default(false);

            // Location and capacity
            $table->string('location')->nullable();
            $table->json('location_details')->nullable(); // Address, coordinates, etc.
            $table->integer('capacity')->nullable(); // Maximum attendees
            $table->integer('registered_count')->default(0); // Current registrations

            // Registration settings
            $table->boolean('registration_enabled')->default(true);
            $table->dateTime('registration_starts_at')->nullable();
            $table->dateTime('registration_ends_at')->nullable();
            $table->decimal('price', 10, 2)->default(0.00); // Event price

            // SEO and metadata
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->string('organizer')->nullable();
            $table->json('organizer_details')->nullable();

            // Publishing
            $table->timestamp('published_at')->nullable();
            $table->string('author')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['status', 'start_date']);
            $table->index(['featured', 'status']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
