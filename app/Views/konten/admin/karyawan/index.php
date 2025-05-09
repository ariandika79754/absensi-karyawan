<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/karyawan"><span class="text-muted fw-light">Karyawan</span></a></h4>
<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Tentang Karyawan</h4>
                <p>Halaman <strong>Karyawan</strong> memberikan informasi lengkap mengenai data seluruh karyawan yang bekerja di RadarTV. Anda dapat melihat, menambah, mengedit, dan menghapus data sesuai kebutuhan.</p>
                <ol>
                    <li>Lihat daftar lengkap karyawan.</li>
                    <li>Tambah data karyawan baru.</li>
                    <li>Edit data karyawan yang sudah ada.</li>
                    <li>Hapus data karyawan dengan mudah.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row ">
                <div class="col-lg-6">
                    <h5 class="card-header">Karyawan</h5>
                </div>
                <div class="col-lg-6 text-end ">
                    <a href="/admin/karyawan/add" class="btn btn-primary me-3 mt-3"><i class='bx bx-plus-circle'></i>Tambah</a>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Alamat</th>
                                    <th>Nomor Handphone</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Status</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($karyawan as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['jabatan']; ?></td>
                                        <td><?= $row['alamat']; ?></td>
                                        <td><?= $row['no_hp']; ?></td>
                                        <td><?= $row['jenis_kelamin']; ?></td>
                                        <td><?= $row['tanggal_lahir']; ?></td>
                                        <td>
                                            <span class="status-badge"
                                                style="background-color: <?= ($row['status'] === 'Aktif') ? '#28a745' : '#dc3545'; ?>;">
                                                <?= $row['status']; ?>
                                            </span>
                                        </td>
                                        <td><img src="/uploads/karyawan/<?= $row['foto'] ?>" alt="gambar" width="50"></td>
                                        <td>
                                            <a href="/admin/karyawan/edit/<?= encrypt_url($row['id']); ?>" class="btn btn-sm btn-success"><i class='bx bx-edit-alt'></i></a>
                                            <a href="#" onclick="confirmDeleteKaryawan('<?= encrypt_url($row['id']); ?>')" class="btn btn-sm btn-danger"><i class='bx bx-trash'></i></a>
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

<style>
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        color: white;

        display: inline-block;
        text-align: center;
    }
</style>
<?= $this->endSection() ?>