<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Dashboard Absensi</h3>
    <p>Selamat datang, <?= $absensi_terakhir[0]['nama'] ?? 'User' ?></p>

    <div class="row mb-4">
        <?php if ($belum_absen): ?>
            <div class="alert alert-warning" role="alert">
                ⚠️Anda belum melakukan absensi hari ini. Silakan absen terlebih dahulu.
            </div>
        <?php endif; ?>

        <!-- Kolom kiri: Statistik -->
        <div class="col-md-6 col-12">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <!-- Hadir: warna hijau pastel -->
                    <div class="card text-dark stat-card" style="height: 120px; background: #d4edda;">
                        <div class="card-body">
                            <h5 class="mb-2">Hadir</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $hadir ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <!-- Sakit: warna kuning pastel -->
                    <div class="card text-dark stat-card" style="height: 120px; background: #fff3cd;">
                        <div class="card-body">
                            <h5 class="mb-2">Sakit</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $sakit ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <!-- Izin: tetap bg-info -->
                    <div class="card text-white bg-info stat-card" style="height: 120px;">
                        <div class="card-body">
                            <h5 class="mb-2 text-white">Izin</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $izin ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <!-- Terlambat: tetap merah -->
                    <div class="card text-white stat-card" style="height: 120px; background: #dc3545;">
                        <div class="card-body">
                            <h5 class="mb-2 text-white">Terlambat</h5>
                            <p class="fs-4 mb-0 mt-2 text-center"><?= $terlambat ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom kanan: Grafik -->
        <div class="col-md-6 col-12">
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

    <style>
        /* CSS untuk tampilan di perangkat mobile */
        /* CSS untuk tampilan di perangkat mobile */
        @media (max-width: 768px) {
            .stat-card {
                margin-left: auto;
                margin-right: auto;
                width: 90%;
                /* Lebar card lebih kecil di perangkat mobile */
                margin-bottom: 15px;
                /* Memberikan jarak antar card */
            }

            .table {
                font-size: 12px;
                /* Menyesuaikan ukuran font untuk tabel di perangkat mobile */
            }

            /* Grafik */
            #absensiChart {
                max-width: 100%;
            }

            /* Mengatur lebar peringatan */
            .alert {
                width: 90%;
                /* Mengatur lebar alert lebih kecil di perangkat mobile */
                margin: 10px auto;
                /* Memusatkan peringatan dan memberi jarak atas dan bawah */
            }

            /* Memberikan jarak antar card statistik */
            .col-md-6.mb-3 {
                margin-bottom: 20px;
                /* Memberikan jarak antar card statistik */
            }
        }
    </style>

    <?= $this->endSection() ?>