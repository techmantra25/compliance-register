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
            $table->enum('relation_type', ['father', 'mother', 'husband']);
            $table->string('language_name');
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
