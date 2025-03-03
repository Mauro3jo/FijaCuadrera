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
        Schema::table('caballo_carrera', function (Blueprint $table) {
            $table
                ->foreign('caballo_id')
                ->references('id')
                ->on('caballos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

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
        Schema::table('caballo_carrera', function (Blueprint $table) {
            $table->dropForeign(['caballo_id']);
            $table->dropForeign(['carrera_id']);
        });
    }
};
