@extends('layouts.layouts')

@section('title', 'Dashboard')

@section('content')
    <!-- Hero -->
    <section class="bg-gray-900 text-white py-14 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex-1">
                <h2 class="text-4xl font-bold mb-4 leading-tight">Selamat Datang di,<br> Sistem Manajemen Penjualan & Operasional BimmerWorks</h2>
                <p class="mb-6 text-gray-300">Kelola transaksi, stok barang, pelayanan, dan laporan harian semua dalam satu sistem</p>
                <a href="#" class="bg-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-red-700">Lihat Laporan</a>
            </div>
            <div class="flex-1">
                <img src="{{ asset('img/bmw.jpg') }}" alt="Mobil Servis" class="w-full rounded-xl shadow-lg">
            </div>
        </div>
    </section>

    <!-- Deskripsi -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <h3 class="text-3xl font-bold mb-10 text-center">Tentang Sistem</h3>
        <p class="text-lg text-gray-700 text-center">
            Sistem manajemen penjualan dan operasional bengkel ini merupakan platform internal yang dikembangkan
            oleh BimmerWorks untuk mengelola seluruh proses penjualan dan operasional bengkel secara terpusat dan
            efisien. Sistem ini dirancang untuk membantu admin dan owner dalam memantau aktivitas harian seperti
            pencatatan transaksi pemesanan, pengelolaan stok barang, pelayanan service kendaraan, hingga penyusunan
            laporan keuangan dan operasional. Dengan sistem ini, semua data terintegrasi dalam satu dashboard yang
            mudah diakses, sehingga mendukung pengambilan keputusan yang cepat, akurat, dan berbasis data. Kehadiran
            sistem ini diharapkan dapat meningkatkan efisiensi kerja, mengurangi kesalahan pencatatan, serta memberikan
            gambaran menyeluruh tentang performa bengkel secara real-time.
        </p>
    </section>

    <!-- Notifikasi -->
    <section class="bg-red-600 text-white py-14">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold mb-3">🔔 Pemberitahuan Penting</h3>
            <p class="mb-6 text-lg">Nanti diisi sama stok barang apa aja yang menipis</p>
            <a href="#" class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">Lihat Stok</a>
        </div>
    </section>

    <!-- Data Operasional -->
    <section class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl font-bold mb-10 text-center">Aktivitas Operasional Hari Ini</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">

                <!-- Jumlah Pelayanan Hari Ini -->
                <div class="card">
                    <div class="text-4xl mb-2">🧰</div>
                    <div class="text-lg font-semibold">18 Pelayanan</div>
                    <div class="text-sm text-gray-600">Hari Ini</div>
                </div>

                <!-- Jumlah Barang yang Digunakan -->
                <div class="card">
                    <div class="text-4xl mb-2">📦</div>
                    <div class="text-lg font-semibold">32 Barang</div>
                    <div class="text-sm text-gray-600">Telah Digunakan</div>
                </div>

                <!-- Pendapatan Hari Ini -->
                <div class="card">
                    <div class="text-4xl mb-2">💰</div>
                    <div class="text-lg font-semibold">Rp 3.250.000</div>
                    <div class="text-sm text-gray-600">Pendapatan Hari Ini</div>
                </div>

                <!-- Seluruh Pendapatan -->
                <div class="card">
                    <div class="text-4xl mb-2">📊</div>
                    <div class="text-lg font-semibold">Rp 145.800.000</div>
                    <div class="text-sm text-gray-600">Total Pendapatan Keseluruhan</div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl font-bold mb-10 text-center">Grafik Data Transaksi</h3>
                {{-- <h3 class="text-xl font-bold mb-6 text-center">Grafik Data Transaksi</h3> --}}
                <div class="grid grid-cols-2 md:grid-cols-2 gap-10">
                    <div class="card">
                        <canvas id="monthlyChart"></canvas>
                    </div>

                    <div class="card">
                        <canvas id="yearlyChart"></canvas>
                    </div>
                        <!-- Grafik Perbulan -->
                        {{-- <div class="bg-white p-4 rounded-lg shadow">
                            <canvas id="monthlyChart"></canvas>
                        </div> --}}

                        <!-- Grafik Pertahun -->
                        {{-- <div class="bg-white p-4 rounded-lg shadow">
                            <canvas id="yearlyChart"></canvas>
                        </div> --}}

                        <!-- Grafik Distribusi Jenis Layanan -->
                        {{-- <div class="bg-white p-4 rounded-lg shadow">
                            <canvas id="servicePieChart"></canvas>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-black text-white py-14">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <!-- Kiri: Logo -->
            <div class="flex-shrink-0">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('img/bmw2.jpeg') }}" alt="Logo BMW" class="h-14">
                    <h2 class="text-lg font-semibold mb-2">
                        <span class="font-bold text-red-500">BIMMERWORKS</span> FOR THE BMW ENTHUSIAST
                    </h2>
                </div>
            </div>

            <!-- Kanan: Kontak -->
            <div>
                <h2 class="text-lg font-semibold mb-2">Kontak Kami</h2>
                <ul class="text-sm space-y-1 text-gray-300">
                    <li>📍 Jl. Kerkof No.82, Leuwigajah, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40532</li>
                    <li>📞 0857-2041-8090</li>
                    <li>📧 info@bimmerworks.com</li>
                    <li>
                    📸 Instagram:
                    <a href="https://instagram.com/bimmerworks.garage" target="_blank" class="hover:underline text-blue-400">
                        @bimmerworks.garage
                    </a>
                    </li>
                    <li>
                    🎵 Tiktok:
                    <a href="https://tiktok.com/@bimmerworks.garage" target="_blank" class="hover:underline text-blue-400">
                        @bimmerworks.garage
                    </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

@endsection

</body>
</html>
