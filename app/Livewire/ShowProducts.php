<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ShowProducts extends Component
{
    public Collection $products;

    public function mount(): void
    {
        // Carga todos los productos cuando el componente se inicializa
        $this->products = Product::all();
    }

    public function render()
    {
        return view('livewire.show-products');
    }
}