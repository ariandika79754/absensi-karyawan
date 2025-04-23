<?= $this->extend('layout/page_auth') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center">
            <a href="/" class="app-brand-link gap-2">
                <span class="text-center">
                    <img src="/template/assets/img/logo/logo.png" alt="" width="150%">
                </span>

            </a>
        </div>
        <!-- /Logo -->
        <h4 align="center"class="mb-2">Toko Ari Andika</h4>
        <p class="mb-4">Masukan username dan password yang benar</p>

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
            <p align="center">Belum punya akun?
            <a href="/auth/register">
                        <small>register now</small>
                    </a></p>
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
            </div>
        </form>


    </div>
</div>

<?= $this->endSection() ?>