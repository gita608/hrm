<?php

use Illuminate\Database\Migrations\Migration;
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

        // Modify the enum column to remove 'company' (database-agnostic approach)
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE holidays MODIFY COLUMN type ENUM('national', 'regional') DEFAULT 'national'");
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE holidays DROP CONSTRAINT IF EXISTS holidays_type_check');
            DB::statement("ALTER TABLE holidays ADD CONSTRAINT holidays_type_check CHECK (type IN ('national', 'regional'))");
            DB::statement("ALTER TABLE holidays ALTER COLUMN type SET DEFAULT 'national'");
        }
        // SQLite doesn't support ALTER COLUMN for enums, so we skip it
        // The validation in the model/controller will enforce the enum values
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE holidays MODIFY COLUMN type ENUM('national', 'regional', 'company') DEFAULT 'company'");
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE holidays DROP CONSTRAINT IF EXISTS holidays_type_check');
            DB::statement("ALTER TABLE holidays ADD CONSTRAINT holidays_type_check CHECK (type IN ('national', 'regional', 'company'))");
            DB::statement("ALTER TABLE holidays ALTER COLUMN type SET DEFAULT 'company'");
        }
        // SQLite doesn't support ALTER COLUMN for enums
    }
};
