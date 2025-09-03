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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            
            // Translatable fields (will be stored as JSON)
            $table->json('title');        // Title in AR/EN
            $table->json('slug');         // URL-friendly slug in AR/EN  
            $table->json('excerpt');      // Short description in AR/EN
            $table->json('content');      // Full content in AR/EN
            $table->json('meta_title')->nullable();     // SEO meta title
            $table->json('meta_description')->nullable(); // SEO meta description
            
            // Non-translatable fields
            $table->string('author')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('reading_time')->nullable(); // in minutes
            
            // Category relationship (will create later)
            $table->foreignId('blog_category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('status');
            $table->index('featured');
            $table->index('published_at');
            $table->index('blog_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
