<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector; // Importamos la clase Vector del paquete oficial

class DocumentChunk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source',
        'content',
        'embedding',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Esto le enseña a Eloquent a manejar la columna 'embedding'
        // como un objeto Vector, permitiendo una asignación fluida.
        'embedding' => Vector::class,
    ];
}