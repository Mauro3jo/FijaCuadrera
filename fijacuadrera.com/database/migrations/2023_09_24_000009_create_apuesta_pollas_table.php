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
        Schema::create('apuesta_pollas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('carrera_id');
            $table->double('Ganancia');
            $table->string('Caballo1');
            $table->double('Monto1');
            $table->string('Caballo2');
            $table->double('Monto2');
            $table->string('Caballo3');
            $table->double('Monto3');
            $table->string('Caballo4');
            $table->double('Monto4');
            $table->string('Caballo5');
            $table->double('Monto5');
            $table->boolean('Estado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apuesta_pollas');
    }
};
