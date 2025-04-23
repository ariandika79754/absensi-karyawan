<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/product"><span class="text-muted fw-light">Product Ari Andika</span></a></h4>
<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Informasi Product Ari Andika</h4>
                <p>Toko Ari Andika menyediakan berbagai macam produk handphone</p>
                <ol>
                    <li>Toko Ari Andika menyediakan berbagai <strong>Handhphone</strong> seperti Oppo, Vivo, Samsung, Iphone dan lain-lainnya.</li>

                </ol>
                <p>Dengan berbagai kategori produk handphone ini, Toko Ari Andika bertujuan untuk memberikan kemudahan dan kenyamanan bagi pelanggan dalam berbelanja telepon genggam.</p>
            </div>
        </div>
    </div>
</div>


<div class="row">

    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row ">
                <div class="col-lg-6">
                    <h5 class="card-header">Product Ari Andika</h5>
                </div>

                <div class="col-lg-12">

                    <div class="table-responsive">

                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($product as $row) : ?>

                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><img src="/uploads/gambarProduct/<?= $row['gambar'] ?>" alt="gambar" width="50"></td>
                                        <td><?= $row['nama_product'] ?></td>
                                        <td><?= $row['nama_kategori'] ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <a href="/pelanggan/transaksi/add/<?= encrypt_url($row['id']); ?>" class="btn btn-sm btn-primary"><i class='bx bx-cart'></i></a>
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