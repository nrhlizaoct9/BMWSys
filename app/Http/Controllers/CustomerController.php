<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index() {
    $customers = Customer::all();
    return view('customers.index', compact('customers'));
    }

    public function create() {
        return view('customers.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required', 'phone' => 'nullable',
            'address' => 'nullable'
        ]);
        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Pelanggan ditambahkan.');
    }
    // lanjut edit, update, destroy mirip

}
