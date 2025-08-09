use App\Models\Barang;
use Illuminate\Http\Request;

Route::get('/generate-kode-barang', function (Request $request) {
    $request->validate([
        'jenis_barang_id' => 'required|exists:jenis_barangs,id'
    ]);

    try {
        $kodeBarang = Barang::generateKodeBarang($request->jenis_barang_id);

        return response()->json([
            'success' => true,
            'kode_barang' => $kodeBarang
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal generate kode barang',
            'error' => $e->getMessage()
        ], 500);
    }
})->middleware('auth:sanctum'); // Tambahkan middleware jika perlu autentikasi
