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
        Schema::table('job_postings', function (Blueprint $table) {
            // UAE Location Details
            $table->enum('uae_emirate', ['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Umm Al Quwain', 'Ras Al Khaimah', 'Fujairah'])->nullable()->after('location');
            $table->string('uae_city')->nullable()->after('uae_emirate');
            
            // Visa and Work Permit
            $table->boolean('visa_sponsorship')->default(false)->after('uae_city');
            $table->boolean('work_permit_required')->default(false)->after('visa_sponsorship');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn([
                'uae_emirate',
                'uae_city',
                'visa_sponsorship',
                'work_permit_required',
            ]);
        });
    }
};
