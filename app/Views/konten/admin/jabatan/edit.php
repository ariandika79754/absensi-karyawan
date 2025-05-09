<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Edit Data Jam Kerja</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/master/jabatan" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <!-- Form untuk mengedit data jam kerja -->
                    <form action="/admin/master/jabatan/update/<?= encrypt_url($jabatan['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $jabatan['jabatan'] ?>" required>
                            </div>

                          
                        </div>

                        <div class="col-lg-6 mt-5">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Format input gaji dengan titik setiap 3 digit
    document.getElementById('gaji_bulanan').addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, ''); // Hapus semua selain angka
        let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format angka dengan titik

        e.target.value = formattedValue;
    });
</script>

<?= $this->endSection() ?>
