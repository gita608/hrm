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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_code')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->foreignId('job_posting_id')->nullable()->constrained('job_postings')->nullOnDelete();
            $table->string('applied_role')->nullable(); // Role they applied for
            $table->date('applied_date');
            $table->string('resume_path')->nullable(); // File path for resume
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['app_received', 'screening', 'scheduled', 'interviewed', 'shortlisted', 'hired', 'rejected', 'withdrawn'])->default('app_received');
            $table->text('notes')->nullable();
            $table->text('experience_summary')->nullable();
            $table->text('education')->nullable();
            $table->text('skills')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
