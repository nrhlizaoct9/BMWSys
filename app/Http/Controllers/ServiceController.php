<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceJob;
use App\Models\Barang;
use App\Models\DetailService;
use App\Models\ServiceJobDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $services = Service::with(['detailBarang', 'detailJasa'])
                    ->orderBy('tanggal', 'desc')
                    ->paginate(10);

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $serviceJobs = ServiceJob::all();
        $barangs = Barang::where('stok', '>', 0)->get();

        return view('services.create', compact('serviceJobs', 'barangs'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'nama_pelanggan' => 'required|string|max:100',
                'plat_nomor' => 'required|string|max:20',
                'keterangan' => 'nullable|string',
                'service_jobs' => 'required|array',
                'service_jobs.*.id' => 'required|exists:service_jobs,id',
                'service_jobs.*.jumlah_jam' => 'required|numeric|min:0.1',
                'barangs' => 'nullable|array',
                'barangs.*.id' => 'required|exists:barangs,id',
                'barangs.*.jumlah' => 'required|integer|min:1',
            ]);

            // Create service header
            $service = Service::create([
                'tanggal' => $validated['tanggal'],
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'plat_nomor' => $validated['plat_nomor'],
                'keterangan' => $validated['keterangan'] ?? null,
                'nomor_invoice' => $this->generateInvoiceNumber(),
                'total' => 0,
            ]);

            $total = 0;

            // Add service jobs
            foreach ($validated['service_jobs'] as $sj) {
                $serviceJob = ServiceJob::findOrFail($sj['id']);

                $subtotal = $serviceJob->tipe_harga == 'per_jam'
                    ? $serviceJob->harga_jual * $sj['jumlah_jam']
                    : $serviceJob->harga_jual;

                ServiceJobDetail::create([
                    'service_id' => $service->id,
                    'service_job_id' => $sj['id'],
                    'jumlah_jam' => $sj['jumlah_jam'],
                    'harga_satuan' => $serviceJob->harga_jual,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Add barangs if any
            if (!empty($validated['barangs'])) {
                foreach ($validated['barangs'] as $brg) {
                    $barang = Barang::findOrFail($brg['id']);

                    // Validasi stok cukup
                    if ($barang->stok < $brg['jumlah']) {
                        throw new \Exception("Stok {$barang->nama_barang} tidak mencukupi");
                    }

                    $subtotal = $barang->harga_jual * $brg['jumlah'];

                    DetailService::create([
                        'service_id' => $service->id,
                        'barang_id' => $brg['id'],
                        'jumlah' => $brg['jumlah'],
                        'harga_satuan' => $barang->harga_jual,
                        'subtotal' => $subtotal,
                    ]);

                    $barang->decrement('stok', $brg['jumlah']);
                    $total += $subtotal;
                }
            }

            // Update total
            $service->update(['total' => $total]);

            DB::commit();

            return redirect()->route('services.index')
                        ->with('success', 'Service berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                    ->with('error', 'Gagal membuat service: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $service->load(['detailJasa', 'detailBarang']);
        $serviceJobs = ServiceJob::all();
        $barangs = Barang::where('stok', '>', 0)->get();

        return view('services.edit', compact('service', 'serviceJobs', 'barangs'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'nama_pelanggan' => 'required|string|max:100',
                'plat_nomor' => 'required|string|max:20',
                'keterangan' => 'nullable|string',
                'service_jobs' => 'required|array|min:1',
                'service_jobs.*.id' => 'required|exists:service_jobs,id',
                'service_jobs.*.jumlah_jam' => 'required|numeric|min:0.1',
                'barangs' => 'nullable|array',
                'barangs.*.id' => 'required_with:barangs|exists:barangs,id',
                'barangs.*.jumlah' => 'required_with:barangs|integer|min:1',
            ]);

            // Update service header
            $service->update([
                'tanggal' => $validated['tanggal'],
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'plat_nomor' => $validated['plat_nomor'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            $total = 0;

            // Sync service jobs
            $service->detailJasa()->delete();
            foreach ($validated['service_jobs'] as $sj) {
                $serviceJob = ServiceJob::findOrFail($sj['id']);

                $subtotal = $serviceJob->tipe_harga == 'per_jam'
                    ? $serviceJob->harga_jual * $sj['jumlah_jam']
                    : $serviceJob->harga_jual;

                $service->detailJasa()->create([
                    'service_job_id' => $serviceJob->id,
                    'jumlah_jam' => $sj['jumlah_jam'],
                    'harga_satuan' => $serviceJob->harga_jual,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Sync barangs
            // First return all stocks
            foreach ($service->detailBarang as $detail) {
                $detail->barang()->increment('stok', $detail->jumlah);
            }

            $service->detailBarang()->delete();

            if (!empty($validated['barangs'])) {
                foreach ($validated['barangs'] as $brg) {
                    $barang = Barang::findOrFail($brg['id']);

                    if ($barang->stok < $brg['jumlah']) {
                        throw new \Exception("Stok {$barang->nama_barang} tidak mencukupi");
                    }

                    $subtotal = $barang->harga_jual * $brg['jumlah'];

                    $service->detailBarang()->create([
                        'barang_id' => $barang->id,
                        'jumlah' => $brg['jumlah'],
                        'harga_satuan' => $barang->harga_jual,
                        'subtotal' => $subtotal,
                    ]);

                    $barang->decrement('stok', $brg['jumlah']);
                    $total += $subtotal;
                }
            }

            // Update total
            $service->update(['total' => $total]);

            DB::commit();

            return redirect()->route('services.index')
                        ->with('success', 'Service berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal memperbarui service: ' . $e->getMessage());
        }
    }

    public function show(Service $service)
    {
        $service->load(['detailJasa', 'detailBarang']);
        return view('services.show', compact('service'));
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        DB::beginTransaction();

        try {
            // Return all stocks first
            foreach ($service->detailBarang as $detail) {
                $detail->barang()->increment('stok', $detail->jumlah);
            }

            $service->detailJasa()->delete();
            $service->detailBarang()->delete();
            $service->delete();

            DB::commit();

            return redirect()->route('services.index')
                         ->with('success', 'Service berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus service: ' . $e->getMessage());
        }
    }

    /**
     * Generate invoice number
     */
    private function generateInvoiceNumber()
    {
        $last = Service::whereYear('tanggal', date('Y'))->count();
        return 'INV/' . date('Y/m/') . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }

    public function exportPdf(Service $service)
    {
        $service->load(['detailJasa.serviceJob', 'detailBarang.barang']);

        $pdf = Pdf::loadView('services.pdf', compact('service'));

        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ]);

        // Bersihkan nomor invoice dari karakter terlarang
        $cleanInvoiceNumber = str_replace(['/', '\\'], '-', $service->nomor_invoice);

        // Untuk preview di browser
        return $pdf->stream("invoice-{$cleanInvoiceNumber}.pdf");

        // Untuk langsung download
        // return $pdf->download('invoice-'.$service->nomor_invoice.'.pdf');

        // Untuk preview di browser
        // return $pdf->stream('invoice-'.$service->nomor_invoice.'.pdf');
    }
}
