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
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('contact_number_alt_1')->nullable();
            $table->string('contact_number_alt_2')->nullable();
            $table->enum('type', ['Agent', 'Candidate'])->default('Agent');

            // For Candidate: belongs to one Assembly
            $table->foreignId('assembly_id')->nullable()->constrained('assemblies')->onDelete('set null');

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
