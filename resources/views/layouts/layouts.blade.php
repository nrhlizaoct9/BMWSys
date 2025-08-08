<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BimmerWorks - Bengkel Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        .card {
            border-left: 4px solid #111827;
            background: #ffffff;
            border-radius: 6px;
            padding: 20px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease;
        }

        /* Styling tambahan untuk datatables */
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background-color: #fff;
            margin: 0 4px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_info {
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #4b5563;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 4px;
            border: 1px solid #d1d5db;
            background-color: #fff;
            color: #111827;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #ef4444;
            color: white !important;
            font-weight: bold;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #f87171;
            color: white !important;
        }

        table.dataTable thead th {
            font-weight: bold;
            background-color: #f3f4f6;
        }

        table.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Posisikan filter (search) ke kanan */
        div.dataTables_wrapper div.dataTables_filter {
            text-align: right;
        }

        div.dataTables_wrapper div.dataTables_length {
            text-align: left;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            margin-left: 0.5rem;
        }

        /* Tata posisi bagian atas DataTables */
        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter {
            display: flex;
            align-items: center;
        }

        div.dataTables_wrapper div.dataTables_length {
            justify-content: flex-start;
        }

        div.dataTables_wrapper div.dataTables_filter {
            justify-content: flex-end;
        }

        /* Agar dua bagian itu ada di satu baris */
        div.dataTables_wrapper .dataTables_length,
        div.dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        div.dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5rem;
            border: 1px solid #ccc;
            padding: 0.4rem 0.6rem;
            border-radius: 4px;
        }

        div.dataTables_wrapper .dataTables_length select {
            border: 1px solid #ccc;
            padding: 0.4rem 0.6rem;
            border-radius: 4px;
            margin: 0 0.5rem;
        }

        /* Responsif: Jadikan satu baris dan ruang antar bagian */
        div.dataTables_wrapper .dataTables_length,
        div.dataTables_wrapper .dataTables_filter {
            width: 50%;
            float: left;
        }

        @media (max-width: 768px) {
            div.dataTables_wrapper .dataTables_length,
            div.dataTables_wrapper .dataTables_filter {
                width: 100%;
                float: none;
                text-align: left !important;
                justify-content: flex-start;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- DataTables + TailwindCSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwind.min.css">
</head>

<body class="bg-white text-gray-900 font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-black text-white px-6 py-4 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-red-500">BimmerWorks</h1>
            <nav class="flex items-center space-x-6 text-sm relative pt-2">
                <a href="{{ route('dashboard') }}" class="pb-2 border-b-2 {{ request()->routeIs('dashboard') ? 'border-red-600 font-bold text-red-600' : 'border-transparent hover:border-gray-300' }}">
                    Dashboard
                </a>

                <!-- Dropdown Data Master -->
                <div x-data="{ open: false }" class="relative inline-block">
                    <button @click="open = !open"
                        class="pb-2 border-b-2 focus:outline-none
                            {{ request()->routeIs(['users.*', 'suppliers.*', 'jenis-barang.*', 'barang.*']) ? 'border-red-600 text-red-600 font-bold' : 'border-transparent hover:border-gray-300' }}">
                        Data Master ▼
                    </button>
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute bg-white text-black mt-2 rounded shadow-md w-48 z-50"
                        >
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                @if(request()->routeIs('users.*'))
                                    <span class="w-2 h-2 bg-red-600 rounded-full inline-block mr-2"></span>
                                @endif
                                Data User
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                @if(request()->routeIs('suppliers.*'))
                                    <span class="w-2 h-2 bg-red-600 rounded-full inline-block mr-2"></span>
                                @endif
                                Data Supplier
                            </a>
                            <a href="{{ route('jenis-barang.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                @if(request()->routeIs('jenis-barang.*'))
                                    <span class="w-2 h-2 bg-red-600 rounded-full inline-block mr-2"></span>
                                @endif
                                Data Jenis Barang
                            </a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Data Barang</a>
                        </div>
                    </div>

                <a href="#" class="pb-2 border-b-2 {{ request()->is('pemesanan*') ? 'border-red-600 text-red-600 font-bold' : 'border-transparent hover:border-gray-300' }}">
                    Pemesanan
                </a>
                <a href="#" class="pb-2 border-b-2 {{ request()->is('pelayanan*') ? 'border-red-600 text-red-600 font-bold' : 'border-transparent hover:border-gray-300' }}">
                    Pelayanan
                </a>
                <a href="#" class="pb-2 border-b-2 {{ request()->is('laporan*') ? 'border-red-600 text-red-600 font-bold' : 'border-transparent hover:border-gray-300' }}">
                    Laporan
                </a>
                <!-- Dropdown Profil -->
                <div x-data="{ open: false }" class="relative">
                    <!-- Tombol bulat (profil) -->
                    <button @click="open = !open" class="w-10 h-10 bg-white text-black font-bold rounded-full flex items-center justify-center focus:outline-none">
                        BW
                    </button>

                    <!-- Menu dropdown -->
                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-40 bg-white text-black rounded shadow-md z-50"
                    >
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-6 text-sm">
        &copy; {{ date('Y') }} BimmerWorks. All rights reserved.
    </footer>

    <script>
        const wrapper = document.getElementById('dropdown-wrapper');
        const menu = document.getElementById('dropdown-menu');

        wrapper.addEventListener('mouseenter', () => {
            menu.classList.remove('hidden');
        });

        wrapper.addEventListener('mouseleave', () => {
            menu.classList.add('hidden');
        });
    </script>

    <script>
        const monthlyChart = document.getElementById('monthlyChart').getContext('2d');
        const yearlyChart = document.getElementById('yearlyChart').getContext('2d');
        // const ctx = document.getElementById('servicePieChart').getContext('2d');

        new Chart(monthlyChart, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Transaksi Per Bulan',
                    data: [12, 19, 14, 20, 23, 17, 12, 18, 21, 16, 11, 13], // Ganti dengan data dinamis jika tersedia
                    backgroundColor: '#ef4444'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        new Chart(yearlyChart, {
            type: 'line',
            data: {
                labels: ['2021', '2022', '2023', '2024', '2025'],
                datasets: [{
                    label: 'Total Transaksi Pertahun',
                    data: [150, 230, 180, 220, 250], // Ganti dengan data dinamis jika tersedia
                    fill: true,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwind.min.js"></script>

    @yield('scripts') <!-- Untuk inject script di halaman tertentu -->

    <div
        x-data="{ show: false, message: '', type: 'success' }"
        x-init="
            @if(session('success'))
                show = true;
                message = '{{ session('success') }}';
                type = 'success';
                setTimeout(() => show = false, 3000);
            @elseif($errors->any())
                show = true;
                message = '{{ $errors->first() }}';
                type = 'error';
                setTimeout(() => show = false, 4000);
            @endif
        "
        x-show="show"
        x-transition
        class="fixed top-32 left-1/2 -translate-x-1/2 z-50 max-w-md w-full"
    >
        <div
            x-bind:class="{
                'bg-green-100 border-green-400 text-green-800': type === 'success',
                'bg-red-100 border-red-400 text-red-800': type === 'error'
            }"
            class="border-l-4 p-4 rounded shadow text-center"
        >
            <p x-text="message" class="text-sm font-medium"></p>
        </div>
    </div>
</body>
</html>
