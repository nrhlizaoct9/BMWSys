@extends('layouts.layouts')

@section('title', 'Edit Barang Masuk')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-12 text-gray-800 text-center">
            <i class="fas fa-dolly" style="color: #2196F3;"></i> Edit Barang Masuk
        </h1>

        <form action="{{ route('pemesanans.update', $pemesanan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Informasi Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Supplier --}}
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $pemesanan->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nomor Surat Jalan --}}
                <div>
                    <label for="nomor_surat_jalan" class="block text-sm font-medium text-gray-700">Nomor Surat Jalan</label>
                    <input type="text" name="nomor_surat_jalan" id="nomor_surat_jalan" value="{{ old('nomor_surat_jalan', $pemesanan->nomor_surat_jalan) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                        placeholder="Contoh: SJ/2025/001" required>
                </div>

                {{-- Tanggal Datang --}}
                <div>
                    <label for="tanggal_datang" class="block text-sm font-medium text-gray-700">Tanggal Datang</label>
                    <input type="date" name="tanggal_datang" id="tanggal_datang" value="{{ old('tanggal_datang', $pemesanan->tanggal_datang->format('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                        required>
                </div>

                {{-- Tipe Pembayaran --}}
                <div>
                    <label for="tipe_pembayaran" class="block text-sm font-medium text-gray-700">Tipe Pembayaran</label>
                    <select name="tipe_pembayaran" id="tipe_pembayaran" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2" required>
                        <option value="tunai" {{ $pemesanan->tipe_pembayaran == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="kredit" {{ $pemesanan->tipe_pembayaran == 'kredit' ? 'selected' : '' }}>Kredit</option>
                    </select>
                </div>

                {{-- Jatuh Tempo --}}
                <div id="tanggal-tempo-container" class="{{ $pemesanan->tipe_pembayaran == 'kredit' ? '' : 'hidden' }}">
                    <label for="tanggal_jatuh_tempo" class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                        value="{{ old('tanggal_jatuh_tempo', optional($pemesanan->tanggal_jatuh_tempo)->format('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                        {{ $pemesanan->tipe_pembayaran == 'kredit' ? 'required' : '' }}>
                </div>
            </div>

            <!-- 2. Daftar Barang -->
            <div class="pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-boxes mr-2" style="color: #6D4C41;"></i> Daftar Barang
                </h3>

                <div id="items-container" class="space-y-4">
                    @foreach($details as $index => $item)
                    <!-- Baris Item -->
                    <div class="item-container">
                        <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            {{-- Barang --}}
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                                <select name="items[{{ $index }}][barang_id]" class="select-barang w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border" required>
                                    <option value="" disabled>Cari barang...</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}"
                                            data-kode="{{ $barang->kode_barang }}"
                                            data-satuan="{{ $barang->satuan }}"
                                            data-harga="{{ $barang->harga_beli }}"
                                            {{ $item->barang_id == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->kode_barang }} - {{ $barang->nama_barang }} ({{ $barang->satuan }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            </div>

                            {{-- Quantity --}}
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                <input type="number" name="items[{{ $index }}][quantity]" min="1" value="{{ old('items.'.$index.'.quantity', $item->quantity) }}"
                                    class="quantity w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border" required>
                            </div>

                            {{-- Harga Beli --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (per satuan)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">Rp</span>
                                    <input type="number" name="items[{{ $index }}][harga_beli]" min="0" step="1000" value="{{ old('items.'.$index.'.harga_beli', $item->harga_beli) }}"
                                        class="harga-beli w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border pl-10"
                                        required>
                                </div>
                            </div>

                            {{-- Diskon --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Diskon</label>
                                <div class="flex">
                                    <input type="number" name="items[{{ $index }}][diskon_nilai]" min="0" value="{{ old('items.'.$index.'.diskon_nilai', $item->diskon_nilai) }}"
                                        class="diskon-nilai w-3/4 rounded-l-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border">
                                    <select name="items[{{ $index }}][diskon_tipe]" class="diskon-tipe w-1/4 rounded-r-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 border-l-0">
                                        <option value="persen" {{ $item->diskon_tipe == 'persen' ? 'selected' : '' }}>%</option>
                                        <option value="nominal" {{ $item->diskon_tipe == 'nominal' ? 'selected' : '' }}>Rp</option>
                                    </select>
                                </div>
                            </div>

                            {{-- PPN --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">PPN</label>
                                <div class="flex">
                                    <input type="number" name="items[{{ $index }}][ppn_nilai]" min="0" value="{{ old('items.'.$index.'.ppn_nilai', $item->ppn_nilai) }}"
                                        class="ppn-nilai w-3/4 rounded-l-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border">
                                    <select name="items[{{ $index }}][ppn_tipe]" class="ppn-tipe w-1/4 rounded-r-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 border-l-0">
                                        <option value="persen" {{ $item->ppn_tipe == 'persen' ? 'selected' : '' }}>%</option>
                                        <option value="nominal" {{ $item->ppn_tipe == 'nominal' ? 'selected' : '' }}>Rp</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Subtotal --}}
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">Rp</span>
                                    <input type="text" name="items[{{ $index }}][subtotal]" class="subtotal w-full rounded-md border-gray-300 bg-gray-100 p-2 pl-10 border" readonly
                                        value="{{ 'Rp ' . number_format($item->subtotal, 0, ',', '.') }}">
                                </div>
                            </div>

                            {{-- Tombol Hapus --}}
                            <div class="md:col-span-1 flex items-center justify-end">
                                <button type="button"
                                    class="remove-item bg-red-600 text-white p-2 rounded-md hover:bg-red-700 transition-colors flex items-center justify-center"
                                    style="width: 36px; height: 36px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Tombol Tambah Barang --}}
                <button type="button" id="add-item" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold shadow">
                    <i class="fas fa-plus mr-1"></i> Tambah Barang
                </button>
            </div>

            <!-- 3. Diskon & PPN Global -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h4 class="font-medium text-blue-800 mb-3 flex items-center">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Diskon & PPN Global
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Diskon Global --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Diskon Global</label>
                        <div class="flex">
                            <input type="number" name="diskon_global_nilai" min="0" value="{{ old('diskon_global_nilai', $pemesanan->diskon_global_nilai) }}"
                                class="diskon-global-nilai w-3/4 rounded-l-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border">
                            <select name="diskon_global_tipe" class="diskon-global-tipe w-1/4 rounded-r-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 border-l-0">
                                <option value="persen" {{ $pemesanan->diskon_global_tipe == 'persen' ? 'selected' : '' }}>%</option>
                                <option value="nominal" {{ $pemesanan->diskon_global_tipe == 'nominal' ? 'selected' : '' }}>Rp</option>
                            </select>
                        </div>
                    </div>

                    {{-- PPN Global --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">PPN Global</label>
                        <div class="flex">
                            <input type="number" name="ppn_global_nilai" min="0" value="{{ old('ppn_global_nilai', $pemesanan->ppn_global_nilai) }}"
                                class="ppn-global-nilai w-3/4 rounded-l-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border">
                            <select name="ppn_global_tipe" class="ppn-global-tipe w-1/4 rounded-r-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 border-l-0">
                                <option value="persen" {{ $pemesanan->ppn_global_tipe == 'persen' ? 'selected' : '' }}>%</option>
                                <option value="nominal" {{ $pemesanan->ppn_global_tipe == 'nominal' ? 'selected' : '' }}>Rp</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Total Pembayaran -->
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-medium text-green-800 flex items-center">
                            <i class="fas fa-calculator mr-2"></i> Total Pembayaran
                        </h4>
                    </div>
                    <div class="text-2xl font-bold text-green-900" id="total-pembayaran">Rp {{ number_format($pemesanan->total_pembayaran, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- 5. Tombol Aksi -->
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('pemesanans.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold transition">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script>
    $(document).ready(function() {
        // Inisialisasi Select2 dengan pencarian
        function initSelect2(element) {
            $(element).select2({
                placeholder: "Cari barang...",
                allowClear: true,
                width: '100%',
                dropdownParent: $(element).closest('.item-container'),
                language: {
                    noResults: function() {
                        return "Barang tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            // placeholder
            $(element).next('.select2-container').find('.select2-selection__placeholder').text('Cari barang...');
        }

        // Inisialisasi untuk semua select barang yang ada
        $('.select-barang').each(function() {
            initSelect2(this);
        });

        // Fungsi untuk mengisi harga otomatis
        function fillHarga(selectElement) {
            const selectedOption = $(selectElement).find('option:selected');
            const hargaBeli = selectedOption.data('harga') || 0;
            const row = $(selectElement).closest('.item-row');

            row.find('.harga-beli').val(hargaBeli).trigger('input');
            calculateSubtotal(row);
        }

        // Fungsi untuk menghitung subtotal per item
        function calculateSubtotal(itemRow) {
            const quantity = parseFloat(itemRow.find('.quantity').val()) || 0;
            const hargaBeli = parseFloat(itemRow.find('.harga-beli').val()) || 0;
            const diskonNilai = parseFloat(itemRow.find('.diskon-nilai').val()) || 0;
            const diskonTipe = itemRow.find('.diskon-tipe').val();
            const ppnNilai = parseFloat(itemRow.find('.ppn-nilai').val()) || 0;
            const ppnTipe = itemRow.find('.ppn-tipe').val();

            // Hitung total sebelum diskon dan ppn
            let subtotal = quantity * hargaBeli;

            // Hitung diskon item
            let diskon = 0;
            if (diskonTipe === 'persen') {
                diskon = subtotal * (diskonNilai / 100);
            } else {
                diskon = diskonNilai;
            }

            // Hitung total setelah diskon
            subtotal -= diskon;

            // Hitung ppn item
            let ppn = 0;
            if (ppnTipe === 'persen') {
                ppn = subtotal * (ppnNilai / 100);
            } else {
                ppn = ppnNilai;
            }

            // Hitung total setelah ppn
            subtotal += ppn;

            // Tampilkan subtotal
            itemRow.find('.subtotal').val(formatRupiah(subtotal));
            itemRow.find('input[name*="[subtotal]"]').val(subtotal);

            return subtotal;
        }

        // Hitung total keseluruhan
        function calculateTotal() {
            let subtotalItems = 0;

            // Hitung subtotal per item
            $('.item-row').each(function() {
                subtotalItems += calculateSubtotal($(this));
            });

            // Hitung diskon global
            const diskonGlobalNilai = parseFloat($('.diskon-global-nilai').val()) || 0;
            const diskonGlobalTipe = $('.diskon-global-tipe').val();

            let diskonGlobal = 0;
            if (diskonGlobalTipe === 'persen') {
                diskonGlobal = subtotalItems * (diskonGlobalNilai / 100);
            } else {
                diskonGlobal = diskonGlobalNilai;
            }

            // Hitung setelah diskon global
            let totalSetelahDiskon = subtotalItems - diskonGlobal;

            // Hitung PPN global
            const ppnGlobalNilai = parseFloat($('.ppn-global-nilai').val()) || 0;
            const ppnGlobalTipe = $('.ppn-global-tipe').val();

            let ppnGlobal = 0;
            if (ppnGlobalTipe === 'persen') {
                ppnGlobal = totalSetelahDiskon * (ppnGlobalNilai / 100);
            } else {
                ppnGlobal = ppnGlobalNilai;
            }

            // Hitung total akhir
            let totalAkhir = totalSetelahDiskon + ppnGlobal;

            // Update total pembayaran
            $('#total-pembayaran').text(formatRupiah(totalAkhir));
        }

        // Format mata uang
        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        // Tambah baris barang
        let itemIndex = {{ count($details) }};
        $('#add-item').click(function() {
            const container = $('#items-container');
            const newItem = $('.item-container:first').clone();

            // Bersihkan nilai input
            newItem.find('input').val('');
            newItem.find('.quantity').val('1');
            newItem.find('.harga-beli, .diskon-nilai, .ppn-nilai').val('0');
            newItem.find('.subtotal').val('Rp 0');
            newItem.find('.select-barang').val(null).trigger('change');
            newItem.find('input[name*="[id]"]').remove(); // Hapus input id untuk item baru

            // Update nama atribut dengan index baru
            newItem.find('[name]').each(function() {
                const name = $(this).attr('name').replace(/\[0\]/g, `[${itemIndex}]`);
                $(this).attr('name', name);
            });

            container.append(newItem);

            // Inisialisasi Select2 untuk baris baru
            initSelect2(newItem.find('.select-barang'));

            itemIndex++;
            calculateTotal();
        });

        // Hapus baris barang
        $(document).on('click', '.remove-item', function() {
            const itemContainer = $(this).closest('.item-container');
            const itemId = itemContainer.find('input[name*="[id]"]').val();

            if (itemId) {
                // Jika item sudah ada di database, tambahkan input hidden untuk menandai penghapusan
                itemContainer.append(`<input type="hidden" name="deleted_items[]" value="${itemId}">`);
            }

            if ($('.item-container').length > 1) {
                itemContainer.fadeOut(300, function() {
                    $(this).remove();
                    calculateTotal();
                });
            } else {
                // Reset form jika hanya tersisa 1 baris
                itemContainer.find('input').not('[type="hidden"]').val('');
                itemContainer.find('.quantity').val('1');
                itemContainer.find('.harga-beli, .diskon-nilai, .ppn-nilai').val('0');
                itemContainer.find('.subtotal').val('Rp 0');
                itemContainer.find('.select-barang').val(null).trigger('change');

                calculateTotal();
            }
        });

        // Auto-fill harga beli ketika barang dipilih
        $(document).on('change', '.select-barang', function() {
            fillHarga(this);
        });

        // Hitung ulang ketika ada perubahan input
        $(document).on('input change', '.quantity, .harga-beli, .diskon-nilai, .diskon-tipe, .ppn-nilai, .ppn-tipe, .diskon-global-nilai, .diskon-global-tipe, .ppn-global-nilai, .ppn-global-tipe', function() {
            calculateTotal();
        });

        // Isi harga awal jika ada data old
        $('.select-barang').each(function() {
            if ($(this).val()) {
                fillHarga(this);
            }
        });

        // Hitung total awal
        calculateTotal();

        $(document).on('change', '#tipe_pembayaran', function() {
            if ($(this).val() === 'kredit') {
                $('#tanggal-tempo-container').removeClass('hidden');
                $('#tanggal_jatuh_tempo').prop('required', true);
            } else {
                $('#tanggal-tempo-container').addClass('hidden');
                $('#tanggal_jatuh_tempo').prop('required', false);
            }
        });
    });
</script>

<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        height: auto !important;
        padding: 0.37rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #ef4444 !important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #f3f4f6 !important;
        color: #111827 !important;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 1px #ef4444 !important;
        outline: none !important;
    }
    .remove-item {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .subtotal {
        min-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 768px) {
        .item-row {
            grid-template-columns: 1fr !important;
        }

        .md\:col-span-1, .md\:col-span-2, .md\:col-span-3 {
            grid-column: span 1 !important;
        }
    }
</style>
@endsection
