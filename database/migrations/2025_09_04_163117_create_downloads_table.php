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
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Translatable: English and Arabic titles
            $table->json('description')->nullable(); // Translatable: English and Arabic descriptions
            $table->string('category')->default('other'); // forms, policies, handbooks, training, reports, guides, templates, other
            $table->string('access_level')->default('public'); // public, employees, managers, admin
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('download_count')->default(0);
            $table->bigInteger('file_size')->nullable(); // File size in bytes
            $table->string('file_type')->nullable(); // MIME type
            $table->timestamps();

            // Indexes for better performance
            $table->index(['category', 'is_active']);
            $table->index(['access_level', 'is_active']);
            $table->index('sort_order');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};
