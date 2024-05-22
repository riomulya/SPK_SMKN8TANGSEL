<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>


<div class="container mx-auto mt-8 px-4 lg:px-0">
    <h1 class="text-3xl font-bold mb-4">Dashboard Siswa</h1>
    <div class="bg-white p-4 rounded mb-8 text-black overflow-x-auto">
        <h2 class="text-xl font-bold mb-4">Detail Perilaku Anda</h2>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap bg-gray-100 text-black">
                <thead>
                    <tr>
                        <th class="border-b border-gray-300 p-2 text-left">Nama</th>
                        <th class="border-b border-gray-300 p-2 text-left">Akun</th>
                        <th class="border-b border-gray-300 p-2 text-left">Poin Positif</th>
                        <th class="border-b border-gray-300 p-2 text-left">Poin Negatif</th>
                        <th class="border-b border-gray-300 p-2 text-left">Peringkat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-b border-gray-300 p-2">John Doe</td>
                        <td class="border-b border-gray-300 p-2">john_doe123</td>
                        <td class="border-b border-gray-300 p-2">150</td>
                        <td class="border-b border-gray-300 p-2">20</td>
                        <td class="border-b border-gray-300 p-2">5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Top 10 Siswa Positif -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
    <!-- Siswa Positif -->
    <div class="bg-white p-4 rounded text-black">
        <h2 class="text-xl font-bold mb-4 text-green-500">Top 10 Siswa Positif</h2>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap bg-green-50 text-black">
                <thead>
                    <tr>
                        <th class="border-b border-gray-300 p-2 text-left">Peringkat</th>
                        <th class="border-b border-gray-300 p-2 text-left">Nama</th>
                        <th class="border-b border-gray-300 p-2 text-left">Poin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-green-100">
                        <td class="border-b border-gray-300 p-2">1</td>
                        <td class="border-b border-gray-300 p-2">John Doe</td>
                        <td class="border-b border-gray-300 p-2">150</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Siswa Negatif -->
<div class="bg-white p-4 rounded text-black">
    <h2 class="text-xl font-bold mb-4 text-red-500">Top 10 Siswa Negatif</h2>
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap bg-red-50 text-black">
            <thead>
                <tr>
                    <th class="border-b border-gray-300 p-2 text-left">Peringkat</th>
                    <th class="border-b border-gray-300 p-2 text-left">Nama</th>
                    <th class="border-b border-gray-300 p-2 text-left">Poin</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-red-100">
                    <td class="border-b border-gray-300 p-2">1</td>
                    <td class="border-b border-gray-300 p-2">Jane Smith</td>
                    <td class="border-b border-gray-300 p-2">-50</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</div>
</div>
</div>




<?= $this->endSection(); ?>