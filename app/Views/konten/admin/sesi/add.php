<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Tambah Data Jam Kerja</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/jam-kerja" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <!-- Form untuk menambah data jam kerja -->
                    <form action="/admin/master/jam-kerja/save" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jam_masuk">Jam Masuk</label>
                                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jam_keluar">Jam Keluar</label>
                                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="sesi" class="form-label">Sesi</label>
                                <select class="form-control" id="sesi" name="sesi" required>
                                    <option value="">Pilih Sesi</option>
                                    <option value="1">Sesi 1</option>
                                    <option value="2">Sesi 2</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-5">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
