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
        Schema::create('f_a_q_s', function (Blueprint $table) {
            $table->id();
            $table->json('question');
            $table->json('answer');
            $table->string('category')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->string('slug')->unique();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['category', 'status']);
            $table->index(['is_featured', 'status']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_a_q_s');
    }
};
