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
        Schema::create('nomination_forms_2_b', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assembly_id')
                ->constrained('assemblies')
                ->cascadeOnDelete();

            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete();
                    
            $table->string('assembly_name');
            $table->string('candidate_name');
            $table->string('relation_name');
            $table->string('postal_address');
            $table->string('candidate_sl_no');
            $table->string('candidate_part_no');
            $table->string('candidate_constituency');

            $table->string('proposer_name');
            $table->string('proposer_sl_no');
            $table->string('proposer_part_no');
            $table->string('proposer_constituency');

            $table->date('nomination_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomination_forms_2_b');
    }
};
