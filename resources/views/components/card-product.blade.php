<!-- resources/views/components/card-product.blade.php -->
<div class="bg-gray-800 rounded overflow-hidden shadow-md hover:shadow-lg transition duration-300">
    <img src="{{ $image ?? 'https://via.placeholder.com/400x200' }}" alt="{{ $title ?? 'Produk' }}" class="w-full h-40 object-cover">
    <div class="p-4">
        <h3 class="text-white text-lg font-semibold mb-1">{{ $title ?? 'Nama Produk' }}</h3>
        <p class="text-red-400 text-sm mb-2">Rp {{ number_format($price ?? 0, 0, ',', '.') }}</p>

        <div class="flex justify-between items-center">
            <button class="bg-redmain hover:bg-red-700 px-3 py-1 text-sm rounded text-white">
                Tambah
            </button>
            @if(isset($stock))
                <span class="text-xs text-gray-400">Stok: {{ $stock }}</span>
            @endif
        </div>
    </div>
</div>
