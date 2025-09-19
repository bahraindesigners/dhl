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
        Schema::create('membership_pages', function (Blueprint $table) {
            $table->id();
            $table->json('how_to_join')->nullable();
            $table->json('union_benefits')->nullable();
            $table->boolean('enable_member_form')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_pages');
    }
};
