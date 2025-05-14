<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4>Rekap Bulanan Absensi</h4>
<div class="card mb-3">

    <!-- Tombol Kembali, diposisikan lebih ke bawah -->
    <div class="d-flex justify-content-end mt-2 mb-4">
        <a href="/karyawan/absensi" class="btn btn-dark me-3">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>

    <!-- Form Filter Bulan & Tahun -->
    <form method="get" action="<?= base_url('karyawan/absensi/rekap-bulanan') ?>" class="filter-form d-flex flex-wrap align-items-start gap-3 mb-3 px-3">
        <div class="bulan-field">
            <select name="bulan" class="form-select" style="min-width: 150px;">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                        <?= DateTime::createFromFormat('!m', $i)->format('F') ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="tahun-field">
            <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control" style="min-width: 100px;" />
        </div>
        <div class="button-group d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
            <a href="<?= base_url('karyawan/absensi/export-pdf?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn btn-success">
                <i class="bx bx-file"></i> Export PDF
            </a>
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