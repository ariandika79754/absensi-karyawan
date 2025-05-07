<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Tambah Data Jabatan</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/master/jabatan" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <!-- Form untuk menambah data jabatan -->
                    <form action="/admin/master/jabatan/save" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                            </div>

                            <!-- <div class="col-lg-6 mb-3">
                                <label class="form-label" for="gaji_bulanan">Gaji Bulanan</label>
                                <input type="text" class="form-control" id="gaji_bulanan" name="gaji_bulanan" required>
                            </div> -->

                        </div>

                        <div class="col-lg-6 mt-5">
                            <button class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk format angka dengan koma -->
<script>
    document.getElementById('gaji_bulanan').addEventListener('input', function (e) {
        let value = e.target.value;
        value = value.replace(/[^0-9]/g, ''); // Menghapus semua karakter selain angka
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Menambahkan koma setiap 3 digit
        e.target.value = value;
    });
</script>

<?= $this->endSection() ?>
