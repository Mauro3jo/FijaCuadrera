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
        Schema::create('apuesta_polla_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apuesta_polla_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('caballo_id');
            $table->string('Resultadoapuesta');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apuesta_polla_users');
    }
};
