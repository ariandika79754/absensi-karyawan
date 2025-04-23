<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/master/users"><span class="text-muted fw-light">Users</span></a></h4>
<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">

            <div class="card-body">
                <h4 class="text-warning">Informasi Users</h4>
                <ol>
                    <li>Menu <strong>Users</strong> memungkinkan admin untuk mengelola data pengguna, menambahkan, mengubah, dan menghapus data pengguna.</li>
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
                    <h5 class="card-header">Users</h5>
                </div>
                <div class="col-lg-6 text-end ">
                    <a href="/admin/master/users/add" class="btn btn-primary me-3 mt-3"><i class='bx bxs-message-alt-add'></i> Tambah</a>
                </div>
                <div class="col-lg-12">

                    <div class="table-responsive">
                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($users as $row) : ?>

                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td>********</td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['role']; ?></td>
                                        <td>
                                            <a href="/admin/master/users/edit/<?= encrypt_url($row['id']); ?>" class="btn btn-sm btn-success"><i class='bx bx-edit-alt'></i></a>
                                            <a href="#" onclick="confirmDeleteUsers('<?= encrypt_url($row['id']); ?>')" class="btn btn-sm btn-danger"><i class='bx bx-trash'></i></a>

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
