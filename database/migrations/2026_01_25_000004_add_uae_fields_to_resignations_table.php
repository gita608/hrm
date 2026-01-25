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
        Schema::table('resignations', function (Blueprint $table) {
            // UAE-specific fields for resignation
            $table->date('visa_cancellation_date')->nullable()->after('last_working_day');
            $table->date('labor_card_cancellation_date')->nullable()->after('visa_cancellation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resignations', function (Blueprint $table) {
            $table->dropColumn([
                'visa_cancellation_date',
                'labor_card_cancellation_date',
            ]);
        });
    }
};
