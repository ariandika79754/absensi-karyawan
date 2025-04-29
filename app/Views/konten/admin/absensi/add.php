<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Tambah Data Absensi</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/absensi" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <!-- Form untuk menambah data absensi -->
                    <form action="/admin/absensi/save" method="POST">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="users_id">Nama Karyawan</label>
                                <select name="users_id" id="users_id" class="form-control" required>
                                    <option value="">Pilih Karyawan</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= $user['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="<?= date('Y-m-d') ?>" readonly
                                    min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="sesi_id" class="form-label">Sesi</label>
                                <select name="sesi_id" id="sesi_id" class="form-control" required>
                                    <option value="">Pilih Sesi</option>
                                    <?php foreach ($sesi as $row): ?>
                                        <option
                                            value="<?= $row['id'] ?>"
                                            data-jam-masuk="<?= $row['jam_masuk'] ?>"
                                            data-jam-keluar="<?= $row['jam_keluar'] ?>">
                                            <?= $row['sesi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" readonly required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" readonly required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Alfa">Alfa</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-5">
                            <button class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk mengisi otomatis jam masuk dan keluar -->
<script>
    document.getElementById('sesi_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const jamMasuk = selectedOption.getAttribute('data-jam-masuk');
        const jamKeluar = selectedOption.getAttribute('data-jam-keluar');

        document.getElementById('jam_masuk').value = jamMasuk || '';
        document.getElementById('jam_keluar').value = jamKeluar || '';
    });
</script>

<?= $this->endSection() ?>