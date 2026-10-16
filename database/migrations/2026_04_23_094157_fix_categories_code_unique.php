<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // பழைய global unique நீக்குங்க
            $table->dropUnique(['code']);

            // Branch + Code சேர்ந்து unique ஆக இருக்கணும்
            $table->unique(['branch_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['branch_id', 'code']);
            $table->unique(['code']);
        });
    }
};