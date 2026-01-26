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
        Schema::create('provident_funds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->decimal('employee_contribution', 10, 2)->default(0);
            $table->decimal('employer_contribution', 10, 2)->default(0);
            $table->decimal('total_contribution', 10, 2)->default(0);
            $table->decimal('employee_percentage', 5, 2)->default(5.00);
            $table->decimal('employer_percentage', 5, 2)->default(5.00);
            $table->date('contribution_date');
            $table->string('month');
            $table->year('year');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('employee_id');
            $table->index(['month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provident_funds');
    }
};
