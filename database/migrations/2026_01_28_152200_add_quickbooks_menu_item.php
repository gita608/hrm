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
        // Get the last order to append after
        $lastOrder = DB::table('menu_items')->max('order') ?: 0;

        // Add QUICKBOOKS Title
        $titleId = DB::table('menu_items')->insertGetId([
            'name' => 'QUICKBOOKS',
            'type' => 'title',
            'icon' => null,
            'route' => null,
            'url' => null,
            'parent_id' => null,
            'order' => $lastOrder + 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add Connection Item
        $itemId = DB::table('menu_items')->insertGetId([
            'name' => 'Connection',
            'type' => 'item',
            'icon' => 'ti ti-brand-linktree',
            'route' => 'quickbooks.index',
            'url' => null,
            'parent_id' => null,
            'order' => $lastOrder + 2,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign to Super Admin (assuming role ID 1 based on general structure)
        $superAdminRole = DB::table('roles')->where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            DB::table('role_menu_item')->insert([
                ['role_id' => $superAdminRole->id, 'menu_item_id' => $titleId],
                ['role_id' => $superAdminRole->id, 'menu_item_id' => $itemId],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $menuItemIds = DB::table('menu_items')
            ->where('name', 'QUICKBOOKS')
            ->orWhere('route', 'quickbooks.index')
            ->pluck('id');

        DB::table('role_menu_item')->whereIn('menu_item_id', $menuItemIds)->delete();
        DB::table('menu_items')->whereIn('id', $menuItemIds)->delete();
    }
};
