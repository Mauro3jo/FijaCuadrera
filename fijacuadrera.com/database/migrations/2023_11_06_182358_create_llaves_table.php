<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('llaves', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_de_llave');
            for ($i = 1; $i <= 10; $i++) {
                $table->string('caballo_1_' . $i)->nullable();
                $table->string('caballo_2_' . $i)->nullable();
            }
            $table->decimal('valor', 8, 2);
            $table->decimal('premio', 8, 2);
            $table->string('estado');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llaves');
    }
};
