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
        Schema::create('apuestamanomano_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apuestamanomano_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('caballo_id');
            $table->string('resultadoapuesta');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apuestamanomano_users');
    }
};
