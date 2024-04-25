<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div>

    <div class="overflow-x-auto my-10 mx-20">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th class="text-xl">Nama</th>
                    <th class="text-xl">Kelas</th>
                    <th class="text-xl">Jenis Kelamin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siswa as $s) : ?>
                    <tr class="hover cursor-pointer" onclick="window.location.href = '/daftar-siswa/<?= $s['nisn']; ?>'">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar placeholder">
                                    <div class="mask rounded-full w-12 h-12 bg-teal-50">
                                        <span class="text-3xl"><?= $s['nama'][0]; ?></span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold"><?= $s['nisn']; ?></div>
                                    <div class="text-sm opacity-50"><?= $s['nama']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?= $s['email']; ?>
                            <br />
                            <span class="badge badge-ghost badge-sm"><?= $s['kelas']; ?></span>
                        </td>
                        <td><?= $s['jenis_kelamin']; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>