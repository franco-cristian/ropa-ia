<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ShowProducts;

Route::get('/', ShowProducts::class);