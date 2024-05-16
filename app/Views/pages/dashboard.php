<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard SMK 8 Tangerang Selatan</h1>
            <p class="text-gray-600 dark:text-gray-400">Selamat datang di sistem informasi SMK Koingan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Card 1: Informasi Sekolah -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full" src="/path/to/school-logo.png" alt="SMK Logo">
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">SMK 8 Tangerang Selatan</h4>
                        <p class="text-gray-500 dark:text-gray-400">Teknologi dan Inovasi</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Jumlah Siswa -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Jumlah Siswa</h4>
                <p class="text-gray-500 dark:text-gray-400">Total: 1200 Siswa</p>
            </div>

            <!-- Card 3: Berita Terbaru -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Berita Terbaru</h4>
                <ul class="text-gray-500 dark:text-gray-400 list-disc pl-5">
                    <li>Penerimaan siswa baru 2023</li>
                    <li>Kegiatan ekstrakurikuler bulan ini</li>
                </ul>
            </div>
        </div>

        <!-- Additional Links or Information -->
        <div class="mt-8">
            <a href="#" class="text-primary-700 dark:text-primary-400 hover:underline">Lihat semua kegiatan</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
