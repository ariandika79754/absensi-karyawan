<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">

    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Edit Data Karyawan</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/karyawan" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <form method="POST" action="/admin/karyawan/update/<?= encrypt_url($karyawan['id']) ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="old_foto" value="<?= $karyawan['foto'] ?>">

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="nama" class="form-label">Nama Karyawan</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $karyawan['nama'] ?>" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select class="form-select" id="jabatan" name="jabatan_id">
                                    <option value="">Pilih Jabatan</option>
                                    <?php foreach ($jabatanList as $jabatan): ?>
                                        <option value="<?= $jabatan['id']; ?>" <?= ($jabatan['id'] == $karyawan['jabatan_id']) ? 'selected' : '' ?>>
                                            <?= $jabatan['jabatan']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $karyawan['alamat'] ?>">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="no_hp" class="form-label">Nomor Handphone</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $karyawan['no_hp'] ?>">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="Laki-laki" <?= $karyawan['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= $karyawan['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Aktif" <?= $karyawan['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="Non-Aktif" <?= $karyawan['status'] == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" onchange="previewImage(event)">
                                <img id="preview" src="/uploads/karyawan/<?= $karyawan['foto'] ?>" alt="Preview Foto" class="img-thumbnail mt-3" style="max-width: 100px;">
                            </div>
                        </div>

                        <div class="col-lg-6 mt-5">
                            <button class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    }
</script>

<?= $this->endSection() ?>