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
        Schema::create('apuestamanomanos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('carrera_id');
            $table->double('Ganancia');
            $table->string('Caballo1');
            $table->string('Caballo2');
            $table->double('Monto1');
            $table->double('Monto2');
            $table->string('Tipo');
            $table->boolean('Estado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apuestamanomanos');
    }
};
