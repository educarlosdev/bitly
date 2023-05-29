<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hits', function (Blueprint $table) {
            $table->fullText(['user_agent']);
        });
    }

    public function down(): void
    {
        Schema::table('hits', function (Blueprint $table) {
            $table->dropFullText(['user_agent']);
        });
    }
};
