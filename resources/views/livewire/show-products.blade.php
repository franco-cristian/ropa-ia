<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Catálogo de Productos</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:-translate-y-1">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-600 bg-gray-100 inline-block px-2 py-1 rounded-full mt-2">{{ $product->category }}</p>
                    <p class="text-gray-700 mt-4">{{ $product->long_description }}</p>
                    <div class="mt-6 flex justify-between items-center">
                        <span class="text-2xl font-bold text-indigo-600">${{ number_format($product->price, 2, ',', '.') }}</span>
                        @if ($product->stock > 0)
                            <span class="text-green-600 font-semibold">{{ $product->stock }} en stock</span>
                        @else
                            <span class="text-red-600 font-semibold">Sin stock</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No hay productos para mostrar.</p>
        @endforelse
    </div>
</div>