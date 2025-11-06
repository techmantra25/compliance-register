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
        Schema::create('discrepancy_reports', function (Blueprint $table) {
            $table->id();

            // Unique identifier for external tracking (e.g., DR-2025-0001)
            $table->string('unique_id')->unique();

            // Foreign key relation to assemblies table
            $table->foreignId('assembly_id')->constrained('assemblies')->onDelete('cascade');

            // Platform or source of report (e.g., Facebook, Twitter, News Article)
            $table->string('social_media')->nullable();

            // Main report or description of discrepancy
            $table->text('report')->nullable();
            $table->string('source_url')->nullable(); // link to the original post or article
            $table->boolean('is_verified')->default(false); // flag after verification

            // Report sentiment or verification result: Positive / Negative / Neutral
            $table->enum('report_type', ['Positive', 'Negative', 'Neutral'])->default('Neutral');

            // Optionally, track who submitted the report
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discrepancy_reports');
    }
};
