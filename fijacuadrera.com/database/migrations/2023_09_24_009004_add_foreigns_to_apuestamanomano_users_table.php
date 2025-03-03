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
        Schema::table('apuestamanomano_users', function (Blueprint $table) {
            $table
                ->foreign('apuestamanomano_id')
                ->references('id')
                ->on('apuestamanomanos')
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
        Schema::table('apuestamanomano_users', function (Blueprint $table) {
            $table->dropForeign(['apuestamanomano_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['caballo_id']);
        });
    }
};
