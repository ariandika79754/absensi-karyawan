<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h1>Dashboard Absensi</h1>
    <p>Selamat datang, Admin</p>

    <div class="row mb-4">
        <!-- Grafik Kehadiran -->
        <div class="col-md-6 col-12">
            <div class="card mb-3 h-100 card-custom">
                <div class="card-body" style="max-height: 370px; overflow-y: auto;">
                    <h5 class="card-title">Grafik Kehadiran 7 Hari Terakhir</h5>
                    <canvas id="absensiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="col-md-6 col-12">
            <div class="card mb-3 h-100 card-custom">
                <div class="card-body" style="max-height: 370px; overflow-y: auto;">
                    <h5 class="card-title">Riwayat Absensi 1 Bulan Terakhir</h5>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($absensi_terakhir as $absen) : ?>
                                <tr>
                                    <td><?= $absen['nama'] ?></td>
                                    <td><?= $absen['tanggal'] ?></td>
                                    <td><?= $absen['jam_masuk'] ?></td>
                                    <td><?= $absen['jam_keluar'] ?></td>
                                    <td><?= $absen['status'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('absensiChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($grafik['tanggal']) ?>,
            datasets: [{
                label: 'Jumlah Hadir',
                data: <?= json_encode($grafik['hadir']) ?>,
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>

<style>
    /* CSS untuk mobile */
    @media (max-width: 768px) {
        .card-custom {
            margin-left: auto;
            margin-right: auto;
            width: 90%;  /* Lebar card lebih kecil di perangkat mobile */
        }
    }
</style>

<?= $this->endSection() ?>
