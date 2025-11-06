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
        Schema::create('agent_assemblies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('assembly_id')->constrained('assemblies')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['agent_id', 'assembly_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_assemblies');
    }
};
