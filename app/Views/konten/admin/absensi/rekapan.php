<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4">
    <a href="/admin/absensi"><span class="text-muted fw-light">Data Absensi</span></a> / Rekapan Bulanan
</h4>
<div class="card mb-3">
    <div class="col-lg- text-end">
        <a href="/admin/absensi" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
    </div>
    <h4 class="card-header">Filter Rekapan Absensi</h4>

    <div class="card-body">
        <form action="/admin/absensi/rekapan" method="get" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label for="bulan" class="form-label">Bulan</label>
                <select name="bulan" id="bulan" class="form-select">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= ($bulan == $m) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="tahun" class="form-label">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    <?php for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++): ?>
                        <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="users_id" class="form-label">Nama Karyawan</label>
                <select name="users_id" id="users_id" class="form-select">
                    <option value="">-- Semua Karyawan --</option>
                    <?php foreach ($karyawan as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= ($users_id == $k['id']) ? 'selected' : '' ?>>
                            <?= $k['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="/admin/absensi/exportPdf?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&users_id=<?= $users_id ?>" class="btn btn-success w-100">Export PDF</a>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <h5 class="card-header">Rekapan Absensi Bulan <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h5>
    <div class="table-responsive p-3">
        <table class="table" id="example" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Sesi</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($rekapan as $row): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['nama_karyawan']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['sesi']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td><?= $row['keterangan']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>