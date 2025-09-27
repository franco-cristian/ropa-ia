<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ShowProducts;
use App\Livewire\Chatbot;

Route::get('/', Chatbot::class);
Route::get('/productos', ShowProducts::class);