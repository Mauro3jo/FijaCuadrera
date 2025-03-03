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
        Schema::table('apuesta_pollas', function (Blueprint $table) {
            $table
                ->foreign('carrera_id')
                ->references('id')
                ->on('carreras')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apuesta_pollas', function (Blueprint $table) {
            $table->dropForeign(['carrera_id']);
        });
    }
};
