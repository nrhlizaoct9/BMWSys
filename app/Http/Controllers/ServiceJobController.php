<?php

namespace App\Http\Controllers;

use App\Models\ServiceJob;
use Illuminate\Http\Request;

class ServiceJobController extends Controller
{
    public function index()
    {
        $services = ServiceJob::paginate(10);
        return view('service_jobs.index', compact('services'));
    }

    public function create()
    {
        return view('service_jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'estimasi_waktu' => 'nullable|string|min:0',
            'tipe_harga' => 'required|in:tetap,per_jam',
            'harga_jual' => 'required|numeric|min:0',
            'hpp_jasa' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        ServiceJob::create($request->all());

        return redirect()->route('service_jobs.index')
                         ->with('success', 'Layanan servis berhasil ditambahkan');
    }

    public function edit(ServiceJob $serviceJob)
    {
        return view('service_jobs.edit', compact('serviceJob'));
    }

    public function update(Request $request, ServiceJob $serviceJob)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'estimasi_waktu' => 'nullable|string|min:0',
            'tipe_harga' => 'required|in:tetap,per_jam',
            'harga_jual' => 'required|numeric|min:0',
            'hpp_jasa' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $serviceJob->update($request->all());

        return redirect()->route('service_jobs.index')
                         ->with('success', 'Layanan servis berhasil diperbarui');
    }

    public function destroy(ServiceJob $serviceJob)
    {
        $serviceJob->delete();

        return redirect()->route('service_jobs.index')
                         ->with('success', 'Layanan servis berhasil dihapus');
    }
}
