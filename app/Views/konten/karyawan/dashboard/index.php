<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Dashboard Absensi</h3>
    <p>Selamat datang, <?= $absensi_terakhir[0]['nama'] ?? 'User' ?></p>

    <div class="row mb-4">
        <!-- Kolom kiri: Statistik -->
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card text-black bg-success" style="height: 120px;">
                        <div class="card-body">
                            <h5>Hadir</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $hadir ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card text-black" style="height: 120px; background: #FFFF00;">
                        <div class="card-body">
                            <h5>Sakit</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $sakit ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card text-black bg-info" style="height: 120px;">
                        <div class="card-body">
                            <h5>Izin</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $izin ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card text-black" style="height: 120px; background: #FF0000">
                        <div class="card-body">
                            <h5>Alpha</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $alpha ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom kanan: Grafik -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Grafik Kehadiran 7 Hari Terakhir</h5>
                    <canvas id="absensiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat: Full width -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
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
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

    <?= $this->endSection() ?>