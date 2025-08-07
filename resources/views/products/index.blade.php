@extends('layouts.app')
@section('title', 'Daftar Produk')

@section('content')
<h2 class="text-2xl font-bold mb-4">Produk Suku Cadang</h2>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    @foreach ($products as $product)
        <div class="bg-gray-800 p-4 rounded shadow">
            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/150' }}" class="w-full h-32 object-cover mb-2">
            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
            <p class="text-sm text-gray-400">Kategori: {{ $product->category }}</p>
            <p class="text-sm">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</p>
            <div class="mt-2">
                <a href="{{ route('products.edit', $product->id) }}" class="text-sm text-blue-400">Edit</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
