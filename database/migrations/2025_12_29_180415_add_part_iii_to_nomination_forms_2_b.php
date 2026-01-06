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
            $table->enum('election_type', ['general', 'bye'])->default('general');
            $table->string('state_name', 100);

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
