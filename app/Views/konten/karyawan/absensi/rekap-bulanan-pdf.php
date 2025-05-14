<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi Bulan <?= $namaBulan ?> <?= $tahun ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h1,
        h3 {
            text-align: center;
            color: #2c3e50;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 15px;
        }

        .table th,
        .table td {
            padding: 12px;
            border: 1px solid #000;
            text-align: left;
        }

        /* Mengatur kolom nomor menjadi lebih kecil */
        .table td:first-child {
            text-align: center;
            width: 40px;
            /* Ukuran lebih kecil untuk kolom nomor */
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        .header h4 {
            margin: 0;
            padding: 4px;
        }

        .info-karyawan {
            margin-left: 40px;
            line-height: 1.5;
            margin-top: 10px;
        }

        .small-table-container {
            width: 60%;
            margin: 0 auto;
        }

        .small-table {
            width: 100%;
            font-size: 15px;
            border-collapse: collapse;
        }

        .small-table th,
        .small-table td {
            padding: 10px;
            border: 1px solid #000;
            text-align: left;
            /* Pastikan teks pada kolom status dan jumlah rata kiri */
        }

        .centered-heading {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Rekap Absensi Bulan <?= $namaBulan ?> <?= $tahun ?></h1>
        </div>

        <div class="info-karyawan">
            <h4>Berikut ini adalah laporan rekapitulasi absensi bulanan untuk karyawan yang bersangkutan:</h4>
            <?php if (!empty($rekap)): ?>
                <p><strong>Nama Karyawan:</strong> <?= $rekap[0]['nama_karyawan'] ?></p>
            <?php else: ?>
                <p><strong>Nama Karyawan:</strong> Tidak ada data</p>
            <?php endif; ?>

            <p><strong>Nama Perusahaan:</strong> PT Radar Lampung Visual (RadarTv)</p>
            <p><strong>Kabupaten / Provinsi:</strong> Bandar Lampung / Lampung</p>
        </div>

        <!-- Tabel Absensi -->
        <h3 class="centered-heading">Daftar Absensi</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rekap)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($rekap as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['tanggal'] ?></td>
                            <td><?= $r['status'] ?></td>
                            <td><?= !empty($r['keterangan']) ? $r['keterangan'] : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada data absensi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Tabel Status dan Jumlah -->
        <h3 class="centered-heading">Status dan Jumlah</h3>
        <div class="small-table-container">
            <table class="small-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($statusJumlah)): ?>
                        <?php foreach ($statusJumlah as $s): ?>
                            <tr>
                                <td><?= $s['status'] ?></td>
                                <td><?= $s['jumlah'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" style="text-align: center;">Tidak ada data status</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>