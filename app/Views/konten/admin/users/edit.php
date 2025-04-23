<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/master/users"><span class="text-muted fw-light">Users</span></a> > Edit User</h4>

<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Edit User</h4>

                <!-- Flash Messages -->
                <?php if (isset($errors)) : ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if (isset($success)) : ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST" action="/admin/master/users/update/<?= $user['id'] ?>">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="password" class="form-label">Password (Opsional)</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password">
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="bx bx-show"></i>
                                </button>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $user['nama']) ?>" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-5">
                        <button class="btn btn-primary">Perbarui</button>
                        <a href="/admin/master/users" class="btn btn-dark">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Password Visibility -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        }
    });
</script>

<?= $this->endSection() ?>
