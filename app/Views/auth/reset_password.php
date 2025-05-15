<?= $this->extend('layout/page_auth') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Reset Password</h5>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="/auth/reset-password" method="POST">
                        <div class="mb-3 position-relative">
                            <label for="password">Password Baru</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" required />
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', this)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="confirm_password">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required />
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password', this)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan script untuk toggle password -->
<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

<!-- Pastikan Font Awesome disertakan -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<?= $this->endSection() ?>
