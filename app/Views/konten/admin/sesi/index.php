<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/product"><span class="text-muted fw-light">Jam Kerja/Sift</span></a></h4>
<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Informasi Jam Kerja</h4>

                <ol>
                    <li>Jam kerja karyawan diatur dalam beberapa sesi untuk memastikan operasional berjalan lancar.</li>
                    <li>Setiap sesi memiliki jam masuk dan jam keluar yang harus dipatuhi oleh karyawan.</li>
                </ol>
                <p>Pastikan jadwal jam kerja diisi dengan benar agar tidak terjadi kesalahan dalam pembagian tugas.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row ">
                <div class="col-lg-6">
                    <h5 class="card-header">Jam Kerja Karyawan</h5>
                </div>
                <div class="col-lg-6 text-end ">
                    <a href="/admin/master/jam-kerja/add" class="btn btn-primary me-3 mt-3"><i class='bx bxs-message-alt-add'></i> Tambah</a>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Sesi</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($sesi as $row) : ?>

                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['jam_masuk'] ?></td>
                                        <td><?= $row['jam_keluar'] ?></td>
                                        <td><?= $row['sesi'] ?></td>
                                        <td>
                                            <a href="/admin/master/jam-kerja/edit/<?= encrypt_url($row['id']); ?>" class="btn btn-sm btn-success"><i class='bx bx-edit-alt'></i></a>
                                            <a href="#" onclick="confirmDeleteJamKerja('<?= encrypt_url($row['id']); ?>')" class="btn btn-sm btn-danger"><i class='bx bx-trash'></i></a>
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