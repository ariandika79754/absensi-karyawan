<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4>Rekap Bulanan Absensi</h4>

<div class="card mb-3">
    <!-- Tombol Kembali di sebelah kanan -->
    <div class="d-flex justify-content-end mb-3">

        <a href="/karyawan/absensi" class="btn btn-dark me-3"><i class='bx bx-arrow-back'></i> Kembali</a>
    </div>

    <!-- Form Filter Bulan & Tahun -->
    <form method="get" action="<?= base_url('karyawan/absensi/rekap-bulanan') ?>" class="d-flex align-items-center gap-3 mb-3">
        <div>
            <select name="bulan" class="form-select" style="min-width: 150px;">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                        <?= DateTime::createFromFormat('!m', $i)->format('F') ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div>
            <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control" style="min-width: 100px;" />
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
            <a href="<?= base_url('karyawan/absensi/export-pdf?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn btn-success"><i class="bx bx-file"></i> Export PDF</a>

        </div>
    </form>
</div>
<!-- Card Rekap Absensi -->
<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title">Rekap Absensi Bulan <?= $namaBulan ?> <?= $tahun ?></h5>

        <div class="table-responsive">
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rekap)): ?>
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data untuk bulan <?= $namaBulan ?> <?= $tahun ?></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rekap as $r): ?>
                            <tr>
                                <td><?= $r['status'] ?></td>
                                <td><?= $r['jumlah'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>