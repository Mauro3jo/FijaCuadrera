<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caballo_carrera', function (Blueprint $table) {
            $table->unsignedBigInteger('caballo_id');
            $table->unsignedBigInteger('carrera_id');
            $table->double('resultado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caballo_carrera');
    }
};
