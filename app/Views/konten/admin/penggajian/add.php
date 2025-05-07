<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Tambah Data Penggajian</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/penggajian" class="btn btn-dark me-3 mt-3">
                        <i class='bx bx-arrow-back'></i> Kembali
                    </a>
                </div>
                <div class="col-lg-12 p-5">
                    <form method="POST" action="/admin/penggajian/save" id="formPenggajian">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="users_id" class="form-label">Nama Karyawan</label>
                            <select class="form-select" name="users_id" id="users_id" required>
                                <option value="">-- Pilih Karyawan --</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= esc($user['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <input type="month" name="bulan" id="bulan" class="form-control" value="<?= date('Y-m') ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_hadir" class="form-label">Jumlah Hari Hadir</label>
                            <input type="number" name="jumlah_hadir" id="jumlah_hadir" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save me-1'></i> Simpan
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('users_id').addEventListener('change', function() {
        let userId = this.value;
        let bulan = document.getElementById('bulan').value;

        if (userId) {
            fetch(`/admin/penggajian/getJumlahHadir?users_id=${userId}&bulan=${bulan}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('jumlah_hadir').value = data.jumlah_hadir;
                });
        } else {
            document.getElementById('jumlah_hadir').value = '';
        }
    });
</script>

<?= $this->endSection() ?>