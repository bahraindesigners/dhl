<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('posts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: This down migration would need the full posts table structure
        // to properly recreate it. Since we're removing posts entirely,
        // we'll leave this empty for now.
    }
};
