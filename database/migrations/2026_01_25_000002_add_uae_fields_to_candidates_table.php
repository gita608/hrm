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
        Schema::table('candidates', function (Blueprint $table) {
            // Emirates ID
            $table->string('emirates_id')->nullable()->after('phone');
            
            // Passport Information
            $table->string('passport_number')->nullable()->after('emirates_id');
            
            // Nationality
            $table->string('nationality')->nullable()->after('passport_number');
            
            // Visa Status
            $table->enum('visa_status', ['valid', 'expired', 'not_required', 'pending'])->nullable()->after('nationality');
            
            // Current Location in UAE
            $table->enum('current_location_emirate', ['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Umm Al Quwain', 'Ras Al Khaimah', 'Fujairah', 'Outside UAE'])->nullable()->after('visa_status');
            $table->string('current_location_city')->nullable()->after('current_location_emirate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'emirates_id',
                'passport_number',
                'nationality',
                'visa_status',
                'current_location_emirate',
                'current_location_city',
            ]);
        });
    }
};
