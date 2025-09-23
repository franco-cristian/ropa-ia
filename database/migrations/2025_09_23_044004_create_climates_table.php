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
        Schema::create('climates', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->date('date');
            $table->jsonb('weather_data'); // Usamos jsonb para PostgreSQL
            $table->timestamps();

            // Índice para búsquedas rápidas por ciudad y fecha
            $table->unique(['city', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('climates');
    }
};