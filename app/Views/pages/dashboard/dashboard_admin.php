<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-8 mx-auto">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 mx-3">
        <!-- Total pengguna -->
        <div class="bg-gray-100 p-4 rounded border border-gray-300">
            <h2 class="text-xl font-bold mb-2">Total Siswa</h2>
            <p class="text-3xl"><?= $total_siswa; ?></p>
        </div>
        <!-- Perilaku positif card -->
        <div class="bg-green-100 p-4 rounded border border-green-500">
            <h2 class="text-xl font-bold mb-2 text-green-700">Perilaku Positif</h2>
            <p class="text-3xl text-green-700"><?= $total_penghargaan; ?></p>
        </div>
        <!-- perilaku negatif card -->
        <div class="bg-red-100 p-4 rounded border border-red-500">
            <h2 class="text-xl font-bold mb-2 text-red-700">Perilaku Negatif</h2>
            <p class="text-3xl text-red-700"><?= $total_pelanggaran; ?></p>
        </div>
    </div>

    <!-- Peringkat Siswa Positif (Hijau) -->
    <div class="bg-dark-800 p-4 rounded mb-8 mx-5">
        <h2 class="text-xl font-bold mb-4 text-green-500">Peringkat Siswa Positif</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-200 uppercase bg-slate-950">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Poin</th>
                        <th scope="col" class="px-6 py-3">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswa_tertinggi as $st) :  ?>
                        <tr class="bg-slate-800 border-b hover:bg-slate-700">
                            <td class="px-6 py-4 font-medium text-white whitespace-nowrap"><?= $st['nama']; ?></td>
                            <td class="px-6 py-4 text-white"><?= $st['poin']; ?></td>
                            <td class="px-6 py-4 text-white"><?= $st['kelas']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Peringkat Siswa Negatif (Merah) -->
    <div class="bg-dark-800 p-4 rounded mb-8 mx-5">
        <h2 class="text-xl font-bold mb-4 text-red-600">Peringkat Siswa Negatif</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-white uppercase bg-slate-950">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Poin</th>
                        <th scope="col" class="px-6 py-3">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswa_terendah as $sr) :  ?>
                        <tr class="bg-slate-800 border-b hover:bg-slate-700">
                            <td class="px-6 py-4 text-white"><?= $sr['nama']; ?></td>
                            <td class="px-6 py-4 text-white"><?= $sr['poin']; ?></td>
                            <td class="px-6 py-4 text-white"><?= $sr['kelas']; ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="mx-4">

        <div class="max-w-lg p-10 w-full bg-white rounded-lg shadow dark:bg-gray-800 md:p-6 mx-auto">
            <div class="flex justify-between mb-5">
                <div class="grid gap-4 grid-cols-2">
                    <div>
                        <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none mb-2 font-bold text-2xl">Statistic
                        </h5>
                    </div>
                </div>
            </div>
            <div id="line-chart"></div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const chartData = <?= json_encode($chartData) ?>;


    const options = {
        chart: {
            height: "100%",
            maxWidth: "100%",
            type: "line",
            fontFamily: "Inter, sans-serif",
            dropShadow: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        tooltip: {
            enabled: true,
            x: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 10,
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -26
            },
        },
        series: [{
                name: "Total Penghargaan",
                data: [...chartData.rewardData],
                color: "#00ff00",
            },
            {
                name: "Total Pelanggaran",
                data: [...chartData.violationData],
                color: "#FF0000",
            },
        ],
        legend: {
            show: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: false,
        },
    }

    if (document.getElementById("line-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("line-chart"), options);
        chart.render();
    }
</script>
<?= $this->endSection(); ?>