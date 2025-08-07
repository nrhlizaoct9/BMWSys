<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Customer;

class VehicleController extends Controller
{
    public function index() {
    $vehicles = Vehicle::with('customer')->get();
    return view('vehicles.index', compact('vehicles'));
}
public function create() {
    $customers = Customer::all();
    return view('vehicles.create', compact('customers'));
}
public function store(Request $request) {
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'plate_number' => 'required',
        'brand' => 'nullable',
        'type' => 'nullable'
    ]);
    Vehicle::create($request->all());
    return redirect()->route('vehicles.index')->with('success', 'Kendaraan ditambahkan.');
}

}
