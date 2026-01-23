<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing 'company' holidays to 'national' before changing enum
        DB::table('holidays')->where('type', 'company')->update(['type' => 'national']);
        
        // Modify the enum column to remove 'company'
        DB::statement("ALTER TABLE holidays MODIFY COLUMN type ENUM('national', 'regional') DEFAULT 'national'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the enum column with 'company' option
        DB::statement("ALTER TABLE holidays MODIFY COLUMN type ENUM('national', 'regional', 'company') DEFAULT 'company'");
    }
};
