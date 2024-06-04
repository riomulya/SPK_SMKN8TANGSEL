<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?php

$pelanggaran_siswa = 0;
$penghargaan_siswa = 0;

$total_poin_penghargaan = 0;
$total_poin_pelanggaran = 0;

foreach ($perilaku_siswa as $ps) {
    if ($ps['poin'] < 0) {
        $pelanggaran_siswa++;
        $total_poin_pelanggaran += $ps["poin"];
    } else {
        $penghargaan_siswa++;
        $total_poin_penghargaan += $ps["poin"];
    }
} ?>


<div class="m-5">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 mx-3">
        <!-- Total pengguna -->
        <div class=" bg-gray-100 p-4 rounded border border-gray-300">
            <h2 class=" text-xl font-bold mb-2">Total Poin</h2>
            <p class="text-3xl"><?= $siswa['poin'] ?>
                <span class="text-xl">( Perolehan Poin <?= $total_poin_penghargaan + $total_poin_pelanggaran; ?> )</span>
            </p>
        </div>

        <!-- Perilaku positif card -->
        <div class="bg-green-100 p-4 rounded border border-green-500">
            <h2 class="text-xl font-bold mb-2 text-green-700">Total Perilaku Positif</h2>
            <p class="text-3xl text-green-700"><?= $penghargaan_siswa; ?>
                <span class="text-xl">( Poin +<?= $total_poin_penghargaan ?> )</span>
            </p>
        </div>
        <!-- perilaku negatif card -->
        <div class="bg-red-100 p-4 rounded border border-red-500">
            <h2 class="text-xl font-bold mb-2 text-red-700">Total Perilaku Negatif</h2>
            <p class="text-3xl text-red-700"><?= $pelanggaran_siswa; ?>
                <span class="text-xl">( Poin <?= $total_poin_pelanggaran ?> )</span>
            </p>
        </div>
    </div>
</div>

<div class="block md:grid md:grid-cols-3 mx-auto mt-8 px-4 lg:px-0">


    <div>
        <?php if (session('role') == 'admin' || session('role') == 'guru') : ?>
            <div class="relative w-96 h-96 my-10 bg-gray-400 rounded-md pt-24 pb-8 px-4 shadow-md hover:shadow-lg transition mx-auto">
                <div class="absolute rounded-full bg-gray-100 w-28 h-28 p-2 z-10 -top-8 shadow-lg hover:shadow-xl transition">
                    <div class="rounded-full bg-black w-full h-full overflow-auto">
                        <div class="relative inline-flex w-full h-full items-center justify-center overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                            <span class="font-medium text-gray-600 dark:text-gray-300"><?= substr($siswa['nama'], 0, 1); ?></span>
                        </div>
                    </div>
                </div>
                <label class="font-bold text-gray-900 text-lg">
                    <?= $siswa['nama']; ?>
                </label>
                <p class="items-start text-gray-900 mt-2 leading-relaxed">
                    NISN : <?= $siswa['nisn']; ?>
                </p>
                <p class="items-start text-gray-900 mt-2 leading-relaxed">
                    Kelas : <?= $siswa['kelas']; ?>
                </p>
                <p class="items-start text-gray-900 mt-2 leading-relaxed">
                    Email : <?= $siswa['email']; ?>
                </p>
                <p class="items-start text-gray-900 mt-2 leading-relaxed">
                    Tanggal Lahir: <?= formatTanggalIndonesia($siswa['tanggal_lahir']); ?>
                </p>
                <p class="items-start text-gray-900 mt-2 leading-relaxed">
                    Poin : <?= $siswa['poin']; ?>
                </p>
            </div>
        <?php else : ?>
            <h4 class="flex justify-center text-white text-3xl font-bold">
                <?= $siswa['nama']; ?>
            </h4>
        <?php endif; ?>
        <?php if (session('role') == 'admin' || session('role') == 'guru') : ?>
            <div class="mx-auto w-full flex flex-row justify-center">
                <button data-modal-target="penghargaan-modal<?= $siswa['nisn']; ?>" data-modal-toggle="penghargaan-modal<?= $siswa['nisn']; ?>" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
                    <a href="#" class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Penghargaan
                    </a>
                </button>
                <button data-modal-target="pelanggaran-modal<?= $siswa['nisn']; ?>" data-modal-toggle="pelanggaran-modal<?= $siswa['nisn']; ?>" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                    <a href="#" class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Pelanggaran
                    </a>
                </button>
            </div>
        <?php endif ?>
        <div class="max-w-sm w-full mx-auto m-5 bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                <dl>
                    <!-- <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Staistic Poin Per - bulan</dt> -->
                    <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">Statistic Poin</dd>
                </dl>
            </div>


            <div id="bar-chart"></div>
            <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                <div class="flex justify-between items-center pt-5">
                    <!-- Button -->

                    <!-- Dropdown menu -->
                    <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 6 months</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last year</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto md:col-span-2 shadow-md sm:rounded-lg mx-5">
        <!--Tabs widget -->
        <div class="px-5 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Daftar Perilaku Siswa
            </h3>

            <ul class=" text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                <li class="w-full">
                    <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq" aria-selected="true" class="inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Penghargaan</button>
                </li>
                <li class="w-full">
                    <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false" class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Pelanggaran</button>
                </li>
            </ul>
            <div id="fullWidthTabContent" class="px-5 border-t border-gray-200 dark:border-gray-600">
                <div class="hidden pt-4" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if ($perilaku_siswa) : ?>
                            <?php foreach ($perilaku_siswa as $ps) :  ?>
                                <?php if ($ps["poin"] > 0) : ?>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                <div class="ml-3">
                                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                                        <?= $ps["keterangan"]; ?>
                                                    </p>
                                                    <div class="flex items-center  flex-1 text-sm text-green-500 dark:text-green-400">
                                                        <?php if ($ps["poin"] > 0) : ?>
                                                            Penghargaan
                                                        <?php else : ?>
                                                            Pelanggaran
                                                        <?php endif ?>
                                                        <span class="ml-2 text-gray-500"><?= formatTanggalIndonesia($ps['createdAt']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                + <?= $ps["poin"]; ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php else : ?>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center min-w-0">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900 truncate dark:text-white">
                                                Tidak ada Perilaku
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
                <div class="hidden pt-4" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if ($perilaku_siswa) : ?>
                            <?php foreach ($perilaku_siswa as $ps) :  ?>
                                <?php if ($ps["poin"] < 0) : ?>
                                    <li class=" py-3 sm:py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                <div class="ml-3">
                                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                                        <?= $ps["keterangan"]; ?>
                                                    </p>
                                                    <div class="flex items-center  flex-1 text-sm text-red-500 dark:text-red-400">
                                                        <?php if ($ps["poin"] > 0) : ?>
                                                            Penghargaan
                                                        <?php else : ?>
                                                            Pelanggaran
                                                        <?php endif ?>
                                                        <span class="ml-2 text-gray-500"><?= formatTanggalIndonesia($ps['createdAt']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                <?= $ps["poin"]; ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php else : ?>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center min-w-0">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900 truncate dark:text-white">
                                                Tidak ada Perilaku
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="penghargaan-modal<?= $siswa['nisn']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Penghargaan Siswa <?= $siswa['nama']; ?>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="penghargaan-modal<?= $siswa['nisn']; ?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="<?= base_url('/lapor/siswa/penghargaan/' . $siswa['nisn']); ?>" method="post" class="p-4 md:p-5" id="form-penghargaan">
                <?= csrf_field(); ?>
                <input type="hidden" name="penghargaan_type" value="penghargaan">
                <div class="gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
                    <div class="col-span-2 max-w-md mx-auto">
                        <label for="category_penghargaan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Penghargaan</label>
                        <select id="category_penghargaan_<?= $siswa['nisn']; ?>" name="state_penghargaan[]" multiple placeholder="Pilih penghargaan" autocomplete="off" class="bg-gray-600" required>
                            <?php foreach ($penghargaan as $ph) : ?>
                                <option value="<?= $ph["id"]; ?>">
                                    <?= "(" . $ph["kategori"] . ") (" . $ph["keterangan"] . ")  (" . $ph["poin"] . ")" ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <label for="message" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                    <textarea id="message" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tulis Deskripsi Perilaku"></textarea>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Tambah Data
                </button>
            </form>
        </div>
    </div>
</div>



<div id="pelanggaran-modal<?= $siswa['nisn']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Pelanggaran Siswa <?= $siswa['nama']; ?>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="pelanggaran-modal<?= $siswa['nisn']; ?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Form for Pelanggaran -->
            <form action="<?= base_url('/lapor/siswa/pelanggaran/' .  $siswa['nisn']); ?>" method="post" class="p-4 md:p-5">
                <?= csrf_field(); ?>
                <input type="hidden" name="pelanggaran_type" value="pelanggaran">
                <div class="gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
                    <div class="col-span-2 max-w-md mx-auto">
                        <label for="category_pelanggaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih pelanggaran</label>
                        <select id="category_pelanggaran_<?= $siswa['nisn']; ?>" name="state_pelanggaran[]" multiple placeholder="Pilih pelanggaran" autocomplete="off" class="bg-gray-600" required>
                            <?php foreach ($pelanggaran as $pl) : ?>
                                <option value="<?= $pl["id"]; ?>">
                                    <?= "(" . $pl["kategori"] . ") (" . $pl["keterangan"] . ")  (" . $pl["poin"] . ")" ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <label for="message" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                    <textarea id="message" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tulis Deskripsi Perilaku"></textarea>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Tambah Data
                </button>
            </form>
        </div>
    </div>
</div>

<link href="/css/tom-css.css" rel="stylesheet">
<script src="/js/tom-select.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect for each multiple select element
        var select_penghargaan = new TomSelect("#category_penghargaan_<?= $siswa['nisn']; ?>", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
        });

        var select_pelanggaran = new TomSelect("#category_pelanggaran_<?= $siswa['nisn']; ?>", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll("tr[data-href]");
        rows.forEach(row => {
            row.addEventListener("click", function() {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>



<script>
    <?php
    $rewardData = [];
    $violationData = [];

    foreach ($chartDataPerilakuSiswa['rewardData'] as $month => $count) {
        $rewardData[] = $count;
    }

    foreach ($chartDataPerilakuSiswa['violationData'] as $month => $count) {
        $violationData[] = $count;
    }

    $dataForChart = [
        'rewardData' => $rewardData,
        'violationData' => $violationData,
    ];

    ?>
    const chartData = <?= json_encode($dataForChart) ?>;

    const options = {
        series: [{
                name: "Penghargaan",
                color: "#31C48D",
                data: chartData.rewardData, // Menggunakan data penghargaan dari variabel PHP
            },
            {
                name: "Pelanggaran",
                data: chartData.violationData, // Menggunakan data pelanggaran dari variabel PHP
                color: "#F05252",
            }
        ],
        chart: {
            sparkline: {
                enabled: false,
            },
            type: "bar",
            width: "100%",
            height: 400,
            toolbar: {
                show: false,
            }
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {
            bar: {
                horizontal: true,
                columnWidth: "100%",
                borderRadiusApplication: "end",
                borderRadius: 6,
                dataLabels: {
                    position: "top",
                },
            },
        },
        legend: {
            show: true,
            position: "bottom",
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            shared: true,
            intersect: false,
            formatter: function(value) {
                return +value
            }
        },
        xaxis: {
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                },
                formatter: function(value) {
                    return +value
                }
            },
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            }
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -20
            },
        },
        fill: {
            opacity: 1,
        }
    }

    // Render chart dengan data yang sudah disiapkan di dalam view PHP
    if (document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("bar-chart"), options);
        chart.render();
    }
</script>



<?= $this->endSection(); ?>