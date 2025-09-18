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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable(); // Translatable title
            $table->json('content'); // Translatable rich text content
            $table->boolean('show_board_section')->default(false); // Toggle for board section
            $table->json('board_section_title')->nullable(); // Translatable board section title
            $table->json('board_section_description')->nullable(); // Translatable board description
            $table->boolean('is_active')->default(true); // To enable/disable the about page
            $table->integer('sort_order')->default(1); // For ordering if multiple about sections
            $table->timestamps();

            // Indexes for better performance
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
