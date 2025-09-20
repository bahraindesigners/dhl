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
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            
            // Translatable fields
            $table->json('name');         // Category name in AR/EN
            $table->json('description')->nullable(); // Category description in AR/EN
            $table->json('slug');         // URL-friendly slug in AR/EN
            
            // Non-translatable fields
            $table->string('color')->default('#3B82F6'); // Hex color for category
            $table->string('icon')->nullable(); // Heroicon name
            $table->string('status')->default('active'); // active, inactive
            $table->unsignedInteger('sort_order')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
