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
                    <th class="text-xl">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siswa as $s) : ?>
                    <tr class="hover cursor-pointer">
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
                        <th>
                            <button class="btn btn-ghost btn-xs bg-green-500 text-white text-md" data-name="<?= $s['nama']; ?>" onclick="<?= $s['nama']; ?>.showModal()">Reward</button>
                        </th>
                    </tr>
                    <dialog id="<?= $s['nisn']; ?>" class="modal" id="rewardModal">
                        <div class="modal-box h-auto">
                            <form method="dialog">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                            </form>
                            <h3 class="font-bold text-lg" id="studentName">Reward <?= $s['nama']; ?></h3>

                            <form id="rewardForm" method="dialog" class="modal-backdrop">
                                <label class="form-control w-full mt-2">
                                    <div class="label">
                                        <span class="label-text">Pilih Kategori</span>
                                    </div>
                                    <select class="select select-bordered">
                                        <option selected>Pick one</option>
                                        <option>Star Wars</option>
                                        <option>Harry Potter</option>
                                        <option>Lord of the Rings</option>
                                        <option>Planet of the Apes</option>
                                        <option>Star Trek</option>
                                    </select>
                                </label>
                                <label class="form-control w-full mt-2">
                                    <div class="label">
                                        <span class="label-text">Pilih Aktivitas</span>
                                    </div>
                                    <select class="select select-bordered">
                                        <option selected>Pick one</option>
                                        <option>Star Wars</option>
                                        <option>Harry Potter</option>
                                        <option>Lord of the Rings</option>
                                        <option>Planet of the Apes</option>
                                        <option>Star Trek</option>
                                    </select>
                                </label>
                                <label class="form-control">
                                    <div class="label">
                                        <span class="label-text">Detail atau komentar</span>
                                    </div>
                                    <textarea class="textarea textarea-bordered h-24" placeholder="Komentar (opsional)"></textarea>
                                </label>
                                <button onclick="showToast()" class="btn my-5 btn-outline btn-accent">Submit</button>
                            </form>
                        </div>
                    </dialog>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<div class="toast toast-top toast-center hidden" id="toast">
    <div class="alert alert-success">
        <span>Reward Telah diberikan.</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rewardForm');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            setTimeout(function() {
                toast.classList.add('hidden');
            }, 3000); // Menetapkan durasi 3000ms (3 detik) sebelum menghilangkan toast
        });
        closeModal();
    });


    // function showModal(nisn) {
    //     var dialog = document.getElementById(nisn);
    //     dialog.showModal();
    // }

    // function closeModal(nisn) {
    //     var dialog = document.getElementById(nisn);
    //     dialog.close();
    // }
</script>
<?= $this->endSection(); ?>