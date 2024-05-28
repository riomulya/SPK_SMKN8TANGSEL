<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?php

use function PHPUnit\Framework\isEmpty;

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
            <h2 class=" text-xl font-bold mb-2">Total Perilaku</h2>
            <p class="text-3xl"><?= $penghargaan_siswa + $pelanggaran_siswa; ?>
                <span class="text-xl">( Perolehan Poin <?= $total_poin_penghargaan + $total_poin_pelanggaran; ?> )</span>
            </p>
        </div>

        <!-- Perilaku positif card -->
        <div class="bg-green-100 p-4 rounded border border-green-500">
            <h2 class="text-xl font-bold mb-2 text-green-700">Perilaku Positif</h2>
            <p class="text-3xl text-green-700"><?= $penghargaan_siswa; ?>
                <span class="text-xl">( Perolehan Poin +<?= $total_poin_penghargaan ?> )</span>
            </p>
        </div>
        <!-- perilaku negatif card -->
        <div class="bg-red-100 p-4 rounded border border-red-500">
            <h2 class="text-xl font-bold mb-2 text-red-700">Perilaku Negatif</h2>
            <p class="text-3xl text-red-700"><?= $pelanggaran_siswa; ?>
                <span class="text-xl">( Perolehan Poin <?= $total_poin_pelanggaran ?> )</span>
            </p>
        </div>
    </div>
</div>

<div class="block md:grid md:grid-cols-3 mx-auto mt-8 px-4 lg:px-0">

    <div class="mx-auto my-2  w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-96">
        <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400"><?= $siswa["nama"]; ?></h5>

        <ul role="list" class="space-y-5 my-7">
            <li class="flex items-center">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z" />
                </svg>

                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Nisn : <?= $siswa["nisn"]; ?></span>
            </li>
            <li class="flex">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z" />
                </svg>

                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Email : <?= $siswa["email"]; ?></span>
            </li>
            <li class="flex">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z" />
                </svg>

                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Tanggal Lahir : <?= formatTanggalIndonesia($siswa['tanggal_lahir']); ?>
                </span>
            </li>
            <li class="flex">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z" />
                </svg>

                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Jenis Kelamin : <?= $siswa['jenis_kelamin']; ?>
                </span>
            </li>
            <li class="flex">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z" />
                </svg>

                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Tanggal Lahir : <?= $siswa['kelas']; ?>
                </span>
            </li>
            <li class="flex">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z" />
                </svg>
                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Poin : <?= $siswa['poin']; ?>
                </span>
            </li>
        </ul>
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
                                    <div>Tidak Ada Perilaku</div>
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


<?= $this->endSection(); ?>