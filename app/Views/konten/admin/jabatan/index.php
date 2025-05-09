<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/product"><span class="text-muted fw-light">Jabatan</span></a></h4>
<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Informasi Jabatan</h4>
                <ol>
                    <li>Setiap jabatan memiliki tugas dan tanggung jawab yang berbeda.</li>
                    <li>Pastikan setiap jabatan memiliki deskripsi yang jelas agar karyawan dapat melaksanakan tugas dengan baik.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Tabel data jabatan -->
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Daftar Jabatan Karyawan</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/master/jabatan/add" class="btn btn-primary me-3 mt-3"><i class='bx bx-plus-circle'></i>
                    Tambah</a>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($jabatan as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['jabatan'] ?></td>
                                        <!-- Menambahkan pemisah ribuan pada gaji_bulanan -->
                                        <td>
                                            <a href="/admin/master/jabatan/edit/<?= encrypt_url($row['id']); ?>" class="btn btn-sm btn-success"><i class='bx bx-edit-alt'></i></a>
                                            <a href="#" onclick="confirmDeleteJabatan('<?= encrypt_url($row['id']); ?>')" class="btn btn-sm btn-danger"><i class='bx bx-trash'></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>