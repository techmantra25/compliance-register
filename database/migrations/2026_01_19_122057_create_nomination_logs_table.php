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
        Schema::create('nomination_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nomination_id');
            $table->json('form_data');
            $table->longText('pdf_file');
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomination_logs');
    }
};
