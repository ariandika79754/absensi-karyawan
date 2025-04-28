<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rekapan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary-table {
            margin-bottom: 20px;
            width: 30%;
            /* Ukuran lebih kecil */
            margin-left: 0; 
          
        }

        .summary-table th,
        .summary-table td {
            font-size: 11px;
            /* Ukuran font lebih kecil */
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">Rekapan Absensi Bulan <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h2>

    <h4>Berikut ini adalah laporan rekapitulasi absensi bulanan untuk karyawan yang bersangkutan:</h4>
    <?php if (!empty($rekapan)): ?>
        <p><strong>Nama Karyawan:</strong> <?= $rekapan[0]['nama_karyawan'] ?></p>
    <?php else: ?>
        <p><strong>Nama Karyawan:</strong> Tidak ada data</p>
    <?php endif; ?>

    <p><strong>Nama Perusahaan:</strong> PT Radar Lampung Visual (RadarTv)</p>
    <p><strong>Kabupaten / Provinsi:</strong> Bandar Lampung / Lampung</p>

    <!-- Menampilkan jumlah status dalam bentuk tabel kecil -->
    <h4>Jumlah Absensi:</h4>
    <table class="summary-table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Hadir</strong></td>
                <td><?= $statusCount['Hadir'] ?></td>
            </tr>
            <tr>
                <td><strong>Sakit</strong></td>
                <td><?= $statusCount['Sakit'] ?></td>
            </tr>
            <tr>
                <td><strong>Alfa</strong></td>
                <td><?= $statusCount['Alfa'] ?></td>
            </tr>
            <!-- Tambahkan status lainnya jika ada -->
        </tbody>
    </table>

    <table>
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

</body>

</html>