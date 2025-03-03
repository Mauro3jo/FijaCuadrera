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
        Schema::table('apuesta_polla_users', function (Blueprint $table) {
            $table
                ->foreign('apuesta_polla_id')
                ->references('id')
                ->on('apuesta_pollas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('caballo_id')
                ->references('id')
                ->on('caballos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apuesta_polla_users', function (Blueprint $table) {
            $table->dropForeign(['apuesta_polla_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['caballo_id']);
        });
    }
};
