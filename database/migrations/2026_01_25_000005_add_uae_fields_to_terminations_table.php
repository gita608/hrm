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
        Schema::table('terminations', function (Blueprint $table) {
            // UAE-specific fields for termination
            $table->date('visa_cancellation_date')->nullable()->after('notice_date');
            $table->date('labor_card_cancellation_date')->nullable()->after('visa_cancellation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terminations', function (Blueprint $table) {
            $table->dropColumn([
                'visa_cancellation_date',
                'labor_card_cancellation_date',
            ]);
        });
    }
};
