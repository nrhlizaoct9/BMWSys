<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
    $products = Product::all();
    return view('products.index', compact('products'));
}
public function create() {
    return view('products.create');
}
public function store(Request $request) {
    $request->validate([
        'name' => 'required', 'category' => 'required',
        'buy_price' => 'required|numeric', 'sell_price' => 'required|numeric'
    ]);
    Product::create($request->all());
    return redirect()->route('products.index')->with('success', 'Produk ditambahkan.');
}
public function edit($id) {
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
}
public function update(Request $request, $id) {
    $product = Product::findOrFail($id);
    $product->update($request->all());
    return redirect()->route('products.index')->with('success', 'Produk diperbarui.');
}
public function destroy($id) {
    Product::destroy($id);
    return back()->with('success', 'Produk dihapus.');
}

}
