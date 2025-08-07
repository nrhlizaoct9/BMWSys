<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
        ]);

        Service::create($request->all());
        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Service::destroy($id);
        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
