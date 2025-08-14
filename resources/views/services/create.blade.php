@extends('layouts.layouts')

@section('title', 'Tambah Service Baru')

{{-- @if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
</div>
@endif --}}

@section('content')
<div class="max-w-2xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
            <i class="fas fa-car mr-2" style="color: #05325f;"></i> Tambah Service Baru
        </h1>

        <!-- Error Messages -->
        {{-- @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}

        <form id="serviceForm" action="{{ route('services.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                @error('tanggal')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Pelanggan --}}
            <div>
                <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    placeholder="Contoh: Budi Santoso" required>
                @error('nama_pelanggan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Plat Nomor --}}
            <div>
                <label for="plat_nomor" class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                <input type="text" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 uppercase"
                    placeholder="Contoh: B 1234 ABC" required>
                @error('plat_nomor')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jasa Layanan --}}
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-medium text-gray-700 mb-3">Jasa Layanan</h3>
                <div id="jasa-container">
                    <div class="jasa-item space-y-4 mb-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <select name="service_jobs[0][id]" class="jasa-select select2 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2" required>
                                    <option value="">Cari Jasa ...</option>
                                    @foreach($serviceJobs as $job)
                                        <option value="{{ $job->id }}" data-harga="{{ $job->harga_jual }}" data-tipe="{{ $job->tipe_harga }}" {{ old('service_jobs.0.id') == $job->id ? 'selected' : '' }}>
                                            {{ $job->nama_pekerjaan }} ({{ $job->tipe_harga == 'per_jam' ? 'Per Jam' : 'Tetap' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="number" name="service_jobs[0][jumlah_jam]" class="jumlah-jam mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                                    placeholder="Jumlah Jam" min="0.1" step="0.1"
                                    value="{{ old('service_jobs.0.jumlah_jam', 1) }}" required>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">Subtotal: <span class="subtotal">Rp 0</span></span>
                            <button type="button" class="remove-jasa text-red-600 text-sm hover:underline">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" id="tambah-jasa" class="mt-3 text-sm text-blue-600 hover:underline">
                    <i class="fas fa-plus mr-1"></i> Tambah Jasa Layanan
                </button>
                @error('service_jobs')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Barang Digunakan --}}
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-medium text-gray-700 mb-3">Barang Digunakan</h3>
                <div id="barang-container">
                    @if(old('barangs'))
                        @foreach(old('barangs') as $index => $barang)
                        <div class="barang-item space-y-4 mb-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <select name="barangs[{{ $index }}][id]" class="barang-select select2 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                                        <option value="">Cari Barang...</option>
                                        @foreach($barangs as $brg)
                                            <option value="{{ $brg->id }}" data-harga="{{ $brg->harga_jual }}" data-stok="{{ $brg->stok }}" {{ $barang['id'] == $brg->id ? 'selected' : '' }}>
                                                {{ $brg->kode_barang }} {{ $brg->nama_barang }} (Stok: {{ $brg->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <input type="number" name="barangs[{{ $index }}][jumlah]" class="jumlah-barang mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                                        placeholder="Jumlah" min="1" value="{{ $barang['jumlah'] }}">
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">Subtotal: <span class="subtotal">Rp 0</span></span>
                                <button type="button" class="remove-barang text-red-600 text-sm hover:underline">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="barang-item space-y-4 mb-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <select name="barangs[0][id]" class="barang-select select2 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                                    <option value="">Cari Barang ...</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}" data-stok="{{ $barang->stok }}">
                                            {{ $barang->kode_barang }} {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="number" name="barangs[0][jumlah]" class="jumlah-barang mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                                    placeholder="Jumlah" min="1" value="{{ old('barangs.0.jumlah', 1) }}">
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">Subtotal: <span class="subtotal">Rp 0</span></span>
                            <button type="button" class="remove-barang text-red-600 text-sm hover:underline">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                <button type="button" id="tambah-barang" class="mt-3 text-sm text-blue-600 hover:underline">
                    <i class="fas fa-plus mr-1"></i> Tambah Barang
                </button>
                @error('barangs')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    placeholder="Catatan tambahan tentang service">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Total --}}
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-bold text-lg text-right">Total: <span id="total-service">Rp 0</span></h3>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('services.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                    ← Kembali
                </a>
                <button type="submit" id="submitBtn"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        function initSelect2() {
            $('.select2').select2({
                placeholder: "Cari...",
                width: '100%',
                allowClear: true
            });
        }
        initSelect2();

        // Counter untuk index array
        let jasaIndex = {{ old('service_jobs') ? count(old('service_jobs')) : 1 }};
        let barangIndex = {{ old('barangs') ? count(old('barangs')) : 1 }};

        // Tambah Jasa Layanan
        $('#tambah-jasa').click(function() {
            const newItem = $(`<div class="jasa-item space-y-4 mb-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <select name="service_jobs[${jasaIndex}][id]" class="jasa-select select2 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2" required>
                            <option value="">Cari Jasa...</option>
                            @foreach($serviceJobs as $job)
                                <option value="{{ $job->id }}" data-harga="{{ $job->harga_jual }}" data-tipe="{{ $job->tipe_harga }}">
                                    {{ $job->nama_pekerjaan }} ({{ $job->tipe_harga == 'per_jam' ? 'Per Jam' : 'Tetap' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="number" name="service_jobs[${jasaIndex}][jumlah_jam]" class="jumlah-jam mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2" placeholder="Jumlah Jam" min="0.1" step="0.1" value="1" required>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium">Subtotal: <span class="subtotal">Rp 0</span></span>
                    <button type="button" class="remove-jasa text-red-600 text-sm hover:underline">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </div>
            </div>`);

            $('#jasa-container').append(newItem);
            initSelect2();
            jasaIndex++;
        });

        // Tambah Barang
        $('#tambah-barang').click(function() {
            const newItem = $(`<div class="barang-item space-y-4 mb-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <select name="barangs[${barangIndex}][id]" class="barang-select select2 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                            <option value="">Cari Barang...</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}" data-stok="{{ $barang->stok }}">
                                    {{ $barang->kode_barang }} {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="number" name="barangs[${barangIndex}][jumlah]" class="jumlah-barang mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2" placeholder="Jumlah" min="1" value="1">
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium">Subtotal: <span class="subtotal">Rp 0</span></span>
                    <button type="button" class="remove-barang text-red-600 text-sm hover:underline">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </div>
            </div>`);

            $('#barang-container').append(newItem);
            initSelect2();
            barangIndex++;
        });

        // Hapus Jasa
        $(document).on('click', '.remove-jasa', function() {
            $(this).closest('.jasa-item').remove();
            hitungTotal();
        });

        // Hapus Barang
        $(document).on('click', '.remove-barang', function() {
            $(this).closest('.barang-item').remove();
            hitungTotal();
        });

        // Hitung subtotal dan total
        $(document).on('change', '.jasa-select, .jumlah-jam, .barang-select, .jumlah-barang', function() {
            hitungSubtotal($(this).closest('.jasa-item, .barang-item'));
            hitungTotal();
        });

        function hitungSubtotal(item) {
            if (item.hasClass('jasa-item')) {
                const select = item.find('.jasa-select');
                const jumlah = item.find('.jumlah-jam');
                const subtotalEl = item.find('.subtotal');

                if (select.val() && jumlah.val()) {
                    const harga = parseFloat(select.find('option:selected').data('harga'));
                    const tipe = select.find('option:selected').data('tipe');
                    const jam = parseFloat(jumlah.val());

                    const subtotal = tipe === 'per_jam' ? harga * jam : harga;
                    subtotalEl.text('Rp ' + subtotal.toLocaleString('id-ID'));
                } else {
                    subtotalEl.text('Rp 0');
                }
            } else if (item.hasClass('barang-item')) {
                const select = item.find('.barang-select');
                const jumlah = item.find('.jumlah-barang');
                const subtotalEl = item.find('.subtotal');

                if (select.val() && jumlah.val()) {
                    const harga = parseFloat(select.find('option:selected').data('harga'));
                    const jml = parseInt(jumlah.val());

                    const subtotal = harga * jml;
                    subtotalEl.text('Rp ' + subtotal.toLocaleString('id-ID'));
                } else {
                    subtotalEl.text('Rp 0');
                }
            }
        }

        function hitungTotal() {
            let total = 0;

            $('.jasa-item').each(function() {
                const subtotalText = $(this).find('.subtotal').text().replace('Rp ', '').replace(/\./g, '');
                if (subtotalText) {
                    total += parseFloat(subtotalText);
                }
            });

            $('.barang-item').each(function() {
                const subtotalText = $(this).find('.subtotal').text().replace('Rp ', '').replace(/\./g, '');
                if (subtotalText) {
                    total += parseFloat(subtotalText);
                }
            });

            $('#total-service').text('Rp ' + total.toLocaleString('id-ID'));
        }

        // Hitung total awal
        hitungTotal();

        // Form submission handler
$('#serviceForm').on('submit', function(e) {
    // Client-side validation
    let isValid = true;

    // Validate required fields
    $('[required]').each(function() {
        if (!$(this).val()) {
            $(this).addClass('border-red-500');
            isValid = false;
        } else {
            $(this).removeClass('border-red-500');
        }
    });

    // Validate at least one service job
    if ($('.jasa-item').length === 0) {
        alert('Harap tambahkan minimal satu jasa layanan');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
        return false;
    }

    // Show loading state
    $('#submitBtn').html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
    $('#submitBtn').prop('disabled', true);

    // Biarkan form submit normal
    return true;
    });
    });
</script>
@endsection
