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



    <!-- Website traffic -->
    <div class="max-w-sm mx-auto w-full bg-slate-800 rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">

        <div class="flex justify-between items-start w-full">
            <div class="flex-col items-center">
                <div class="flex items-center mb-1">
                    <h5 class="text-xl font-bold leading-none text-white dark:text-white me-1">Diagram Perilaku</h5>
                </div>
            </div>
        </div>
        <!-- Line Chart -->
        <div class="py-6" id="pie-chart"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const chartData = <?= json_encode($chartData) ?>;
    const totalData = <?= $total_pelanggaran + $total_penghargaan ?>;

    const getChartOptions = () => {
        const seriesPercentage = chartData.series.map(value => Math.round((value / totalData) * 100));

        return {
            series: seriesPercentage,
            colors: ["#1C64F2", "#16BDCA", "#9061F9", "#FF4560", "#FEB019", '#FF7F50', '#800000', '#FFD700'],
            chart: {
                height: 420,
                width: "100%",
                type: "pie",
            },
            stroke: {
                colors: ["white"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    labels: {
                        show: true,
                    },
                    size: "100%",
                    dataLabels: {
                        offset: -25
                    }
                },
            },
            labels: [...chartData.labels],
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return value + "%"
                    },
                },
            },
            xaxis: {
                labels: {
                    formatter: function(value) {
                        return value + "%"
                    },
                },
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        }
    }

    if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
        chart.render();
    }
</script>
<?= $this->endSection(); ?>