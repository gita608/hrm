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
        Schema::table('users', function (Blueprint $table) {
            // Emirates ID (Required in UAE)
            $table->string('emirates_id')->unique()->nullable()->after('address');

            // Passport Information
            $table->string('passport_number')->nullable()->after('emirates_id');
            $table->date('passport_expiry_date')->nullable()->after('passport_number');

            // Nationality
            $table->string('nationality')->nullable()->after('passport_expiry_date');

            // Visa Information
            $table->enum('visa_type', ['employment', 'dependent', 'investor', 'student', 'tourist', 'other'])->nullable()->after('nationality');
            $table->string('visa_number')->nullable()->after('visa_type');
            $table->date('visa_expiry_date')->nullable()->after('visa_number');

            // Labor Card Information
            $table->string('labor_card_number')->nullable()->after('visa_expiry_date');
            $table->date('labor_card_expiry_date')->nullable()->after('labor_card_number');

            // Banking Information (UAE)
            $table->string('bank_name')->nullable()->after('labor_card_expiry_date');
            $table->string('iban')->nullable()->after('bank_name');

            // UAE Address Details
            $table->enum('uae_emirate', ['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Umm Al Quwain', 'Ras Al Khaimah', 'Fujairah'])->nullable()->after('iban');
            $table->string('uae_city')->nullable()->after('uae_emirate');
            $table->string('uae_area')->nullable()->after('uae_city');

            // Emergency Contact
            $table->string('emergency_contact_name')->nullable()->after('uae_area');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'emirates_id',
                'passport_number',
                'passport_expiry_date',
                'nationality',
                'visa_type',
                'visa_number',
                'visa_expiry_date',
                'labor_card_number',
                'labor_card_expiry_date',
                'bank_name',
                'iban',
                'uae_emirate',
                'uae_city',
                'uae_area',
                'emergency_contact_name',
                'emergency_contact_phone',
            ]);
        });
    }
};
