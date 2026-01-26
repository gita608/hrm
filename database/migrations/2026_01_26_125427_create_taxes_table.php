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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('min_income', 10, 2)->default(0);
            $table->decimal('max_income', 10, 2)->nullable();
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('fixed_amount', 10, 2)->default(0);
            $table->enum('calculation_method', ['progressive', 'flat', 'fixed'])->default('progressive');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->timestamps();

            $table->index('is_active');
            $table->index(['min_income', 'max_income']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
