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
        // We want to place QUICKBOOKS title below Finance & Payroll section.
        // Finance & Payroll section title is at 24.
        // Payroll item is at 25.
        // DOCUMENTS & SUPPORT is at 26.
        
        // We will shift everything from 26 onwards by 2.
        DB::table('menu_items')->where('order', '>=', 26)->increment('order', 2);

        // Update QUICKBOOKS Title to be at 26
        DB::table('menu_items')
            ->where('name', 'QUICKBOOKS')
            ->update(['order' => 26]);

        // Update Connection Item to be at 27
        DB::table('menu_items')
            ->where('route', 'quickbooks.index')
            ->update(['order' => 27]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse is tricky but for now we just put them back at the end or wherever they were.
        // Since we don't know the exact "back at the end" order without re-calculating, 
        // we leave them at their new positions or just delete/re-add if needed.
    }
};
