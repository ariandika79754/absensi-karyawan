<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="fw-light">Profil Karyawan</span></h4>
<div class="row justify-content-center">

    <?php if (empty($users['username']) || empty($karyawan['nama']) || empty($karyawan['no_hp']) || empty($karyawan['jenis_kelamin']) || empty($karyawan['alamat'])): ?>
        <div class="alert alert-warning mt-3" role="alert">
            ⚠️ Lengkapi profil Anda terlebih dahulu.
        </div>
    <?php endif; ?>
    <form action="/karyawan/users/update" method="POST" enctype="multipart/form-data">
        <div class="card mb-4">
            <h5 class="card-header">Detail Karyawan</h5>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <?php if (!empty($karyawan['foto'])): ?>
                            <img src="/uploads/karyawan/<?= $karyawan['foto'] ?>" alt="Foto Profil" class="img-thumbnail rounded-circle" style="width: 220px; height: 220px; object-fit: cover;">
                        <?php else: ?>
                            <img src="/uploads/karyawan/default.png" alt="Foto Profil Default" class="img-thumbnail rounded-circle" style="width: 220px; height: 220px; object-fit: cover;">
                        <?php endif; ?>

                        <div class="mt-3">
                            <input type="file" class="form-control d-none" id="foto" name="foto" accept="image/*" />
                            <button type="button" class="btn btn-secondary" id="uploadFotoBtn">Upload Foto Baru</button>
                        </div>


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
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" <?= (isset($karyawan['jenis_kelamin']) && $karyawan['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= (isset($karyawan['jenis_kelamin']) && $karyawan['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
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

    <script>
        const uploadButton = document.getElementById("uploadFotoBtn");
        const fileInput = document.getElementById("foto");
        const fotoPreview = document.querySelector(".img-thumbnail"); // cari img preview yang ada

        uploadButton.addEventListener("click", function() {
            fileInput.click();
        });

        fileInput.addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoPreview.src = e.target.result; // ubah src gambar dengan hasil upload
                }
                reader.readAsDataURL(file); // baca file sebagai base64 URL
            }
        });

        document.getElementById("showPasswordBtn").addEventListener("click", function() {
            var passwordInput = document.getElementById("password");
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        });
    </script>



    <?= $this->endSection() ?>