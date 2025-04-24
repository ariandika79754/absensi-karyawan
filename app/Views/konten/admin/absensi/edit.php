<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Edit Data Absensi</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/absensi" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <!-- Form untuk mengedit data absensi -->
                    <form action="/admin/absensi/update/<?= encrypt_url($absensi['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="users_id">Nama Karyawan</label>
                                <select class="form-control" id="users_id" name="users_id" required>
                                    <option value="">Pilih Karyawan</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= $user['id'] == $absensi['users_id'] ? 'selected' : '' ?>><?= $user['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $absensi['tanggal'] ?>" required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="sesi_id" class="form-label">Sesi</label>
                                <select class="form-control" id="sesi_id" name="sesi_id" required>
                                    <option value="">Pilih Sesi</option>
                                    <?php foreach ($sesi as $s): ?>
                                        <option value="<?= $s['id'] ?>" <?= $s['id'] == $absensi['sesi_id'] ? 'selected' : '' ?>><?= $s['sesi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jam_masuk">Jam Masuk</label>
                                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="<?= $absensi['jam_masuk'] ?>" readonly>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jam_keluar">Jam Keluar</label>
                                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" value="<?= $absensi['jam_keluar'] ?>" readonly>
                            </div>


                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Hadir" <?= $absensi['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                                    <option value="Izin" <?= $absensi['status'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                                    <option value="Sakit" <?= $absensi['status'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                                    <option value="Alfa" <?= $absensi['status'] == 'Alfa' ? 'selected' : '' ?>>Alfa</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $absensi['keterangan'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-5">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>