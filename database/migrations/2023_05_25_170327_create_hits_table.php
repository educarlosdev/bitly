<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('hits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('link_id')->constrained()->cascadeOnDelete();
            $table->string('ip');
            $table->string('user_agent');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hits');
    }
};
