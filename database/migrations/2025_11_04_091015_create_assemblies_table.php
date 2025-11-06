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
        Schema::create('assemblies', function (Blueprint $table) {
            $table->id();

            // Foreign key: link to district
            $table->foreignId('district_id')
                ->constrained('districts')
                ->onDelete('cascade');

            // Assembly info
            $table->integer('assembly_number')->unique();
            $table->string('assembly_name_en');
            $table->string('assembly_name_bn');

            // Optional metadata
            $table->string('assembly_code')->nullable();   // official short code if applicable
            $table->enum('status', ['active', 'inactive'])->default('active'); // useful for filtering

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assemblies');
    }
};
