<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->unique();
            $table->string('title');
            $table->enum('letter_type', ['offer', 'appointment', 'experience', 'relieving', 'warning', 'appreciation', 'promotion', 'transfer', 'other'])->default('other');
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->date('issue_date');
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'issued', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_letters');
    }
};
