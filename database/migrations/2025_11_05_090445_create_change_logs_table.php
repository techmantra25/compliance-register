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
        Schema::create('change_logs', function (Blueprint $table) {
            $table->id();

            // 🔹 Which module/table the change belongs to
            $table->string('module_name'); // e.g., "Candidate", "DiscrepancyReport", "Document"

            // 🔹 The specific record (from that module)
            $table->unsignedBigInteger('module_id')->nullable();

            // 🔹 What action happened
            $table->string('action'); // e.g., "Created", "Updated", "Verified", "Rejected"

            // 🔹 Optional description for context
            $table->text('description')->nullable();

            // 🔹 Before and after data snapshots (optional)
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();

            // 🔹 For document-related actions (optional)
            $table->string('document_name')->nullable();

            // 🔹 Admin or user who made the change
            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('admins')
                ->onDelete('set null');

            // 🔹 Optional technical audit info
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_logs');
    }
};
