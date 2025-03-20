<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pendapatan -->
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-semibold dark:text-white">Total Pendapatan</h2>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPendapatan) }}</p>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-semibold dark:text-white">Total Transaksi</h2>
            <p class="text-2xl font-bold text-blue-500">{{ number_format($totalTransaksi) }}</p>
        </div>

        <!-- Total Produk Terjual -->
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-semibold dark:text-white">Total Produk Terjual</h2>
            <p class="text-2xl font-bold text-indigo-500">{{ number_format($totalProdukTerjual) }}</p>
        </div>
    </div>
    <div class="flex justify-end mb-4">
        <select id="filterWaktu" class="p-2 border border-gray-900 rounded-md bg-gray-300 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus">
            <option value="1">1 Hari Terakhir</option>
            <option value="7" selected>7 Hari Terakhir</option>
            <option value="30">30 Hari Terakhir</option>
        </select>
        <button onclick="updateChart()" class="ml-2 p-2 bg-blue-500 text-white rounded">Filter</button>
    </div>

    <div class="flex w-full gap-6">
        <div class="w-1/2 bg-gray-300 dark:bg-gray-900 p-6 mt-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-center dark:text-white">Grafik Jumlah Transaksi (7 Hari Terakhir)</h2>
            <canvas id="transaksiChart"></canvas>
        </div>

        <div class="w-1/2 bg-gray-300 dark:bg-gray-900 p-6 mt-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-center dark:text-white">Grafik Pendapatan (7 Hari Terakhir)</h2>
            <canvas id="pendapatanChart"></canvas>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const transaksiCtx = document.getElementById('transaksiChart').getContext('2d');
    const pendapatanCtx = document.getElementById('pendapatanChart').getContext('2d');

    const chartData = @json($chartData);

    const labels = chartData.map(item => item.date);
    const transaksiData = chartData.map(item => item.total_transaksi);
    const pendapatanData = chartData.map(item => item.total_pendapatan);

    // Grafik Jumlah Transaksi
    new Chart(transaksiCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: transaksiData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Grafik Pendapatan
    new Chart(pendapatanCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: pendapatanData,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});

</script>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
