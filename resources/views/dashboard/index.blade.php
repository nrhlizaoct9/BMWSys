<canvas id="grafikTransaksiBulanan" height="120"></canvas>
<script>
    const ctx = document.getElementById('grafikTransaksiBulanan').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Jumlah Transaksi',
                    data: @json($jumlahTransaksi),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Omzet',
                    data: @json($totalOmzet),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    type: 'line', // bisa juga dijadikan line chart
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Omzet (Rp)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Transaksi Per Bulan – Tahun {{ date("Y") }}'
                }
            }
        }
    });
</script>
