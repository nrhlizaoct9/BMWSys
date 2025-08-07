<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StockOpnameController extends Controller
{
    public function index() {
    $products = Product::all();
    return view('stockopname.index', compact('products'));
}
public function update(Request $request) {
    foreach ($request->stocks as $id => $stock) {
        $product = Product::find($id);
        if ($product) {
            $product->stock = $stock;
            $product->save();
        }
    }
    return back()->with('success', 'Stok diperbarui.');
}

}
