<!-- konten/kps/users/index.php -->

<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="fw-light">Profile users</span></h4>
<div class="row">

    <div class="col-lg-10 mb-4 order-0">
        <form action="/admin/users/update" method="POST" enctype="multipart/form-data">

            <div class="card mb-4">
                <h5 class="card-header">Detail users</h5>
                <!-- Akun -->
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nama" class="form-label">Username</label>
                            <input class="form-control" type="text" id="username" name="username" disabled value="<?= isset($users) ? $users['username'] : '' ?>" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input class="form-control <?= isset($errors['password']) ? 'is-invalid ' : ''; ?>" type="password" id="password" name="password" value="" />
                                <button type="button" class="btn btn-outline-secondary" id="showPasswordBtn">Show</button>
                            </div>
                            <?php if (isset($errors['password'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $errors['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>


                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                        </div>

                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("showPasswordBtn").addEventListener("click", function() {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
</script>

<?= $this->endSection() ?>