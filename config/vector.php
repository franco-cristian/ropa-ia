<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Vector Embedding Dimension
    |--------------------------------------------------------------------------
    |
    | Especifica la dimensión de los vectores de embedding que usará tu
    | aplicación. Esto asegura consistencia y permite una fácil
    | configuración desde un solo lugar.
    |
    */
    'dimension' => env('VECTOR_DIMENSION', 768),
];