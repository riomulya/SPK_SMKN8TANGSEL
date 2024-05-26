<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
// Fungsi untuk menampilkan toast
function showToast($type, $message)
{
    $icon = ($type === 'error') ? 'red' : 'green';
    $id = 'toast-' . $type;
?>

    <div id="<?= $id ?>" class="flex z-10 fixed top-5 right-5 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-<?= $icon ?>-500 bg-<?= $icon ?>-100 rounded-lg dark:bg-<?= $icon ?>-800 dark:text-<?= $icon ?>-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <?php if ($type === 'error') : ?>
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                <?php else : ?>
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                <?php endif; ?>
            </svg>
            <span class="sr-only"><?= ucfirst($type) ?> icon</span>
        </div>
        <?php if (isset($type) && $type) : ?>
            <div class="ms-3 text-sm font-normal">
                <?= is_array($message) ? implode(', ', $message) : $message ?>
            </div>
        <?php else : ?>
            <div class="ms-3 text-sm font-normal"><?= $message ?></div>
        <?php endif ?>

        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#<?= $id ?>" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
    <script>
        // Menghilangkan toast secara otomatis setelah 5 detik
        setTimeout(function() {
            var toast = document.getElementById('<?= $id ?>');
            if (toast) {
                toast.remove();
            }
        }, 5000);
    </script>

<?php } ?>

<?php if (session()->has('error')) : ?>
    <?php showToast('error', session('error')); ?>
<?php endif; ?>

<?php if (session()->has('success')) : ?>
    <?php showToast('success', session('success')); ?>
<?php endif; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js" defer></script>


<span class="flex relative overflow-x-auto mx-2 sm:mx-12 mt-5" aria-label="Breadcrumb">
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
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Lapor Siswa</span>
            </div>
        </li>
    </ol>
</span>


<div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-2 sm:mx-10 my-10 ">
    <div class="pb-4 bg-white dark:bg-slate-600 md:flex sm:block justify-between mt-2 ms-2">

        <form method="post" class="md:w-1/2 sm:w-1/5 mb-2 md:m-0">
            <label for="cari-nama-siswa" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="cari-nama-siswa" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari Keyword" />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>

    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-lg text-center">
                    Nama Siswa
                </th>
                <th scope="col" class="px-6 py-3 text-lg text-center">
                    Nisn
                </th>
                <th scope="col" class="px-6 py-3 text-lg text-center">
                    Email
                </th>
                <th scope="col" class="px-6 py-3 text-lg text-center">
                    Kelas
                </th>
                <th scope="col" class="px-6 py-3 text-lg text-center">
                    Tanggal Lahir
                </th>
                <th scope="col" class="px-6 py-3 text-lg text-center">
                    Jenis Kelamin
                </th>
                <th scope="col" class="px-6 py-3 text-lg text-center">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($siswa as $s) : ?>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">

                    <th scope="row" class="px-6 py-4 font-medium text-xl text-center text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $s['nama']; ?>
                    </th>
                    <td class="px-6 py-4 text-xl text-center">
                        <?= $s['nisn']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl text-center">
                        <?= $s['email']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl text-center">
                        <?= $s['kelas']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl text-center">
                        <?= formatTanggalIndonesia($s['tanggal_lahir']); ?>
                    </td>
                    <td class="px-6 py-4 text-xl text-center">
                        <?= $s['jenis_kelamin']; ?>
                    </td>
                    <td class="px-6 py-4 text-xl text-center">
                        <button data-modal-target="penghargaan-modal<?= $s['nisn']; ?>" data-modal-toggle="penghargaan-modal<?= $s['nisn']; ?>" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
                            <a href="#" class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Penghargaan
                            </a>
                        </button>
                        <button data-modal-target="pelanggaran-modal<?= $s['nisn']; ?>" data-modal-toggle="pelanggaran-modal<?= $s['nisn']; ?>" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                            <a href="#" class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Pelanggaran
                            </a>
                        </button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?= $pager->links("siswa", "custom_pagination"); ?>
</div>

<?php foreach ($siswa as $s) : ?>
    <div id="penghargaan-modal<?= $s['nisn']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Penghargaan Siswa <?= $s['nama']; ?>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="penghargaan-modal<?= $s['nisn']; ?>">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="<?= base_url('/lapor/siswa/penghargaan'); ?>" method="post" class="p-4 md:p-5" id="form-penghargaan">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="penghargaan_type" value="penghargaan">
                    <div class="gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
                        <div class="col-span-2 max-w-md mx-auto">
                            <label for="category_penghargaan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Penghargaan</label>
                            <select id="category_penghargaan" name="state_penghargaan[]" multiple placeholder="Pilih penghargaan" autocomplete="off" class="bg-gray-600" required>
                                <?php foreach ($penghargaan as $ph) : ?>
                                    <option value="<?= $ph["id"]; ?>">
                                        <?= "(" . $ph["kategori"] . ") (" . $ph["keterangan"] . ")  (" . $ph["poin"] . ")" ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Tambah Data
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>


<?php foreach ($siswa as $s) : ?>
    <div id="pelanggaran-modal<?= $s['nisn']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Pelanggaran Siswa <?= $s['nama']; ?>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="pelanggaran-modal<?= $s['nisn']; ?>">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Form for Pelanggaran -->
                <form action="<?= base_url('/lapor/siswa/pelanggaran'); ?>" method="post" class="p-4 md:p-5">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="pelanggaran_type" value="pelanggaran">
                    <div class="gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
                        <div class="col-span-2 max-w-md mx-auto">
                            <label for="category_pelanggaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih pelanggaran</label>
                            <select id="category_pelanggaran" name="state_pelanggaran[]" multiple placeholder="Pilih pelanggaran" autocomplete="off" class="bg-gray-600" required>
                                <?php foreach ($pelanggaran as $pl) : ?>
                                    <option value="<?= $pl["id"]; ?>">
                                        <?= "(" . $pl["kategori"] . ") (" . $pl["keterangan"] . ")  (" . $pl["poin"] . ")" ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Tambah Data
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

<link href="/css/tom-css.css" rel="stylesheet">
<script src="/js/tom-select.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect for each multiple select element
        var select_penghargaan = new TomSelect("#category_penghargaan", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
        });

        var select_pelanggaran = new TomSelect("#category_pelanggaran", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
        });
    });
</script>


<?= $this->endSection(); ?>