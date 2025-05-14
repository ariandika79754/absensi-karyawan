<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4">
    <a href="/admin/absensi"><span class="text-muted fw-light">Data Absensi</span></a>
</h4>

<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Informasi Absensi Karyawan</h4>

                <ol>
                    <li>Absensi digunakan untuk mencatat kehadiran setiap karyawan berdasarkan jam kerja yang ditentukan.</li>
                    <li>Status absensi dapat berupa Hadir, Izin, Sakit, atau Alfa.</li>
                </ol>
                <p>Pastikan setiap data absensi dicatat dengan akurat untuk keperluan evaluasi karyawan.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Rekap Absensi Karyawan</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/absensi/rekapan" class="btn btn-warning me-3 mt-3">
                        <i class='bx bx-calendar'></i> Rekapan Bulanan
                    </a>
                    <a href="/admin/absensi/add" class="btn btn-primary me-2 mt-3">
                    <i class='bx bx-plus-circle'></i>
                    Tambah
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal</th>
                                    <th>Sesi</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($absensi as $row): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['tanggal']; ?></td>
                                        <td><?= $row['sesi']; ?></td>
                                        <td><?= $row['jam_masuk']; ?></td>
                                        <td><?= $row['jam_keluar']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= !empty($row['keterangan']) ? $row['keterangan'] : '-' ?></td>
                                        <td>
                                            <a href="/admin/absensi/edit/<?= encrypt_url($row['id']); ?>" class="btn btn-sm btn-success">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <a href="#" onclick="confirmDeleteAbsensi('<?= encrypt_url($row['id']); ?>')" class="btn btn-sm btn-danger">
                                                <i class='bx bx-trash'></i>
                                            </a>
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