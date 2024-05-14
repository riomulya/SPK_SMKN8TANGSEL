<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>



<span class="flex relative overflow-x-auto mx-12 mt-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                </svg>
                Home
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Setting Siswa</span>
            </div>
        </li>
    </ol>
</span>


<div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-10 my-10">
    <div class="pb-4 bg-white dark:bg-gray-900 flex justify-between mt-2 ms-2">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="table-search" class="block pt-3  ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari Nama Siswa">
        </div>
        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <a class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Tambah Data Siswa
            </a>
        </button>
    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-lg">
                    Nama Siswa
                </th>
                <th scope="col" class="px-6 py-3 text-lg">
                    Nisn
                </th>
                <th scope="col" class="px-6 py-3 text-lg">
                    Email
                </th>
                <th scope="col" class="px-6 py-3 text-lg">
                    Kelas
                </th>
                <th scope="col" class="px-6 py-3 text-lg">
                    Tanggal Lahir
                </th>
                <th scope="col" class="px-6 py-3 text-lg">
                    Jenis Kelamin
                </th>
                <th scope="col" class="px-20 py-3 text-lg">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($siswa as $s) : ?>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">

                    <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $s['nama']; ?>
                    </th>
                    <td class="px-6 py-4 text-xl">
                        <?= $s['nisn']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl">
                        <?= $s['email']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl">
                        <?= $s['kelas']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl">
                        <?= date("d F Y", strtotime($s['tanggal_lahir'])); ?>
                    </td>
                    <td class="px-6 py-4 text-xl">
                        <?= $s['jenis_kelamin']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl">
                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
                            <a href="#" class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Edit
                            </a>
                        </button>
                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                            <a href="#" class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Delete
                            </a>
                        </button>
                    </td>
                </tr>

            <?php endforeach ?>

        </tbody>
    </table>
</div>


<?= $this->endSection(); ?>