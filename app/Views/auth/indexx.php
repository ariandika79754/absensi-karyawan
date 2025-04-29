<?= $this->extend('layout/page_auth') ?>

<?= $this->section('content') ?>
<div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                    <div class="d-flex justify-content-center py-4">
                        <a href="index.html" class="logo d-flex align-items-center w-auto">
                            <img src="assets/img/logo.png" alt="">
                            <span class="d-none d-lg-block">E-RadarTV</span>
                        </a>
                    </div><!-- End Logo -->

                    <div class="card mb-3">

                        <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                <p class="text-center small">Enter your username & password to login</p>
                            </div>
                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <form class="mb-3" action="/auth/check-auth" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Username</label>
                                    <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid ' : ''; ?>" id="email" name="username" placeholder="Masukan email atau username" autofocus />
                                    <?php if (isset($errors['username'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['username'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Password</label>

                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control  <?= isset($errors['password']) ? 'is-invalid ' : ''; ?>" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        <?php if (isset($errors['password'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['password'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                                </div>
                            </form>

                        </div>
                    </div>



                </div>
            </div>
        </div>

    </section>

</div>
<script>
    document.querySelector('.input-group-text').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var icon = this.querySelector('i');

        // Toggle antara password dan text
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bx-hide'); // Hapus ikon mata tersembunyi
            icon.classList.add('bx-show'); // Ganti dengan ikon mata terlihat
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bx-show'); // Hapus ikon mata terlihat
            icon.classList.add('bx-hide'); // Ganti dengan ikon mata tersembunyi
        }
    });
</script>


<?= $this->endSection() ?>