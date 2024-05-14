<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="flex flex-wrap justify-center">
    <div class="card w-full sm:w-96 glass mx-5 my-10 p-10">
        <div class="avatar mb-5">
            <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                <img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
            </div>
        </div>
        <p class="badge badge-ghost badge-lg my-1">Nama : <?= $siswa['nama']; ?></p>
        <p class="badge badge-ghost badge-lg my-1">NISN : <?= $siswa['nisn']; ?></p>
        <p class="badge badge-ghost badge-lg my-1">Email : <?= $siswa['email']; ?></p>
        <p class="badge badge-ghost badge-lg my-1">Tanggal Lahir : <?= date("F jS, Y", strtotime($siswa['tanggal_lahir'])); ?></p>
        <p class="badge badge-ghost badge-lg my-1">Jenis Kelamin : <?= $siswa['jenis_kelamin']; ?></p>
        <p class="badge badge-ghost badge-lg my-1">Kelas : <?= $siswa['kelas']; ?></p>
        <p class="badge badge-ghost badge-lg my-1">Point : <?= $siswa['poin']; ?></p>
    </div>
    <div class="my-10 w-1/2 xl:mx-10">
        <div class="stats shadow xl:w-[75%]">
            <div class="md:flex">
                <div class="stat place-items-center">
                    <div class="stat-title">Penghargaan</div>
                    <div class="stat-value text-green-600">0</div>
                    <div class="stat-desc text-green-600">From January 1st to February 1st</div>
                </div>

                <div class="stat place-items-center">
                    <div class="stat-title">Pelanggaran</div>
                    <div class="stat-value text-red-600">0</div>
                    <div class="stat-desc text-red-600">↗︎ 40 (2%)</div>
                </div>

                <div class="stat place-items-center">
                    <div class="stat-title">Total Perilaku</div>
                    <div class="stat-value text-primary">0</div>
                    <div class="stat-desc text-primary">↘︎ 90 (14%)</div>
                </div>
            </div>
        </div>

        <div class="collapse bg-green-600 card">
            <input type="checkbox" class="peer" />
            <div class="collapse-title bg-green-600 text-primary-content peer-checked:bg-green-400 peer-checked:text-secondary-content">
                Penghargaan
            </div>
            <div class="collapse-content bg-primary text-primary-content peer-checked:bg-green-400 peer-checked:text-secondary-content">
                <p>Tidak Ada Aktivitas</p>
            </div>
        </div>
        <div class="h-56 grid grid-cols-1 gap-4 content-between">
            <div class="collapse bg-base-100 card my-5">
                <input type="checkbox" class="peer" />
                <div class="collapse-title bg-red-600 text-primary-content peer-checked:bg-red-400 peer-checked:text-secondary-content">
                    Pelanggaran
                </div>
                <div class="collapse-content bg-primary text-primary-content peer-checked:bg-red-400 peer-checked:text-secondary-content">
                    <p>Tidak Ada Aktivitas</p>
                </div>
            </div>
            <div>
                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Beri Penghargaan
                    </span>
                </button>
                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Laporkan
                    </span>
                </button>
            </div>
        </div>
    </div>

</div>
<div class="divider w-[75%] mx-auto">Surat Peringatan</div>
<p class="mx-auto my-10">Tidak Ada Surat Peringatan</p>



<?= $this->endSection(); ?>