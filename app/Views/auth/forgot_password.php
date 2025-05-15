<?= $this->extend('layout/page_auth') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Lupa Password</h5>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="/auth/forgot-password" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required />
    </div>
    <div class="d-grid mb-2">
        <button type="submit" class="btn btn-primary">Cek email</button>
    </div>
    <div class="d-grid">
        <a href="/" class="btn btn-link">Kembali ke Login</a>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-image: url('assets/img/lg-bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    @media (min-width: 992px) {
        .card {
            width: 100%;
            max-width: 480px;
            /* bisa disesuaikan */
        

        
            background-color: rgba(255, 255, 255, 0.95);
            /* Biar card tetap jelas */
            backdrop-filter: blur(5px);
            /* Efek blur untuk kesan modern */
        }

        .logo-img {
            width: 80px;
            /* atau ukuran yang kamu mau */
            height: auto;
        }
    }
</style>
<?= $this->endSection() ?>
