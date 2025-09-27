<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Habilitar la extensión pgvector si no existe
        DB::statement('CREATE EXTENSION IF NOT EXISTS vector');

        Schema::create('document_chunks', function (Blueprint $table) {
            $table->id();
            $table->string('source'); // Nombre del archivo original
            $table->text('content');  // Texto del chunk
            // El helper ->vector() viene del paquete pgvector/laravel
            $table->vector('embedding', config('vector.dimension'));
            $table->timestamps();
        });

        // Crear un índice HNSW para búsquedas vectoriales extremadamente rápidas.
        // vector_l2_ops es la distancia euclidiana, un estándar para embeddings de texto.
        DB::statement('CREATE INDEX document_chunks_embedding_idx ON document_chunks USING hnsw (embedding vector_l2_ops)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_chunks');
    }
};