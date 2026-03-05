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
        Schema::table('nomination_forms_2_b', function (Blueprint $table) {
            $table->unsignedTinyInteger('candidate_age');
            $table->string('party_name')->nullable();
            $table->enum('party_type', ['national', 'state'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nomination_forms_2_b', function (Blueprint $table) {
            //
        });
    }
};
