<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/penggajian"><span class="text-muted fw-light">Penggajian Karyawan</span></a></h4>
<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Tentang gaji karyawan</h4>
                <p>Halaman <strong> Penggajian Karyawan</strong> memberikan informasi lengkap mengenai data penggajian karyawan yang bekerja di RadarTV. Anda dapat melihat, menambah, mengedit, dan menghapus data sesuai kebutuhan.</p>
                <ol>
                    <li>Lihat daftar lengkap karyawan.</li>
                    <li>Tambah data penggajian baru.</li>
                    <li>Edit data gaji karyawan yang sudah ada.</li>
                    <li>Hapus data gaji karyawan dengan mudah.</li>
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
                    <h5 class="card-header">Penggajian Karyawan</h5>
                </div>
                <div class="col-lg-6 text-end ">
                    <a href="/admin/penggajian/add" class="btn btn-primary me-3 mt-3"><i class='bx bxs-message-alt-add'></i> Tambah</a>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Bulan</th>
                                    <th>Jumlah Hadir</th>
                                    <th>Gaji Pokok</th>
                                    <th>Total Gaji</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($penggajian as $row) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($row['nama']) ?></td>
                                        <td><?= esc($row['bulan']) ?></td>
                                        <td><?= $row['jumlah_hadir'] ?></td>
                                        <td>Rp <?= number_format($row['gaji_pokok'], 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($row['total_gaji'], 0, ',', '.') ?></td>
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

<?= $this->endSection() ?>