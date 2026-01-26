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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('referral_code')->unique()->nullable();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade'); // Employee who made the referral
            $table->string('referred_first_name');
            $table->string('referred_last_name');
            $table->string('referred_email')->unique();
            $table->string('referred_phone')->nullable();
            $table->foreignId('job_posting_id')->nullable()->constrained('job_postings')->nullOnDelete();
            $table->date('referral_date');
            $table->enum('status', ['pending', 'contacted', 'interviewed', 'shortlisted', 'hired', 'rejected', 'withdrawn'])->default('pending');
            $table->decimal('referral_bonus', 10, 2)->nullable(); // Bonus amount if hired
            $table->enum('bonus_status', ['pending', 'approved', 'paid'])->nullable();
            $table->date('bonus_paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->text('referred_skills')->nullable();
            $table->text('referred_experience')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
