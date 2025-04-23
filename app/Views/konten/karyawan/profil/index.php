<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="fw-light">Profil Karyawan</span></h4>
<div class="row justify-content-center">

    <form action="/admin/users/update" method="POST" enctype="multipart/form-data">


        <div class="card mb-4">
            <h5 class="card-header">Detail Karyawan</h5>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4 d-flex justify-content-center">
                        <!-- Foto Profil -->
                        <?php if (!empty($karyawan['foto'])): ?>
                            <img src="/uploads/karyawan/<?= $karyawan['foto'] ?>" alt="Foto Profil" class="img-thumbnail rounded-circle" style="width: 220px; height: 220px; object-fit: cover;">
                        <?php else: ?>
                            <img src="/uploads/karyawan/default.png" alt="Foto Profil Default" class="img-thumbnail rounded-circle" style="width: 220px; height: 220px; object-fit: cover;">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input class="form-control" type="text" id="username" name="username" value="<?= $users['username'] ?? '' ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input class="form-control" type="password" id="password" name="password" value="" />
                                    <button type="button" class="btn btn-outline-secondary" id="showPasswordBtn">Show</button>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input class="form-control" type="text" id="nama" name="nama" value="<?= $karyawan['nama'] ?? '' ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input class="form-control" type="text" id="jabatan" name="jabatan" disabled value="<?= $karyawan['jabatan'] ?? '' ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input class="form-control" type="text" id="no_hp" name="no_hp" value="<?= $karyawan['no_hp'] ?? '' ?>" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <input class="form-control" type="text" id="jenis_kelamin" name="jenis_kelamin" value="<?= $karyawan['jenis_kelamin'] ?? '' ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <input class="form-control" type="text" id="status" name="status" disabled value="<?= $karyawan['status'] ?? '' ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat"><?= $karyawan['alamat'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
        </div>
    </form>
</div>
</div>
<script>
    document.getElementById("showPasswordBtn").addEventListener("click", function() {
        var passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    });
</script>
<?= $this->endSection() ?>