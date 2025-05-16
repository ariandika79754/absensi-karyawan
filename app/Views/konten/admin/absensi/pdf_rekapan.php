<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rekapan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            min-height: 1122px; /* Tinggi A4 dalam piksel untuk 96 DPI */
            box-sizing: border-box;
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
            margin-left: 0;
        }

        .summary-table th,
        .summary-table td {
            font-size: 11px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .logo-cell {
            vertical-align: middle;
            padding-right: 10px;
        }

        .title-cell {
            vertical-align: middle;
            text-align: center;
            width: 100%;
        }

        hr {
            border: 1px solid #000;
            margin-top: 0;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Header dengan logo dan judul -->
    <table class="header-table">
        <tr>
            <td class="logo-cell" style="width: 80px;">
                <?php
                $logoPath = FCPATH . 'assets/img/logo.png';
                if (file_exists($logoPath)) :
                    $logoBase64 = base64_encode(file_get_contents($logoPath));
                    $logoMime = mime_content_type($logoPath);
                ?>
                    <img src="data:<?= $logoMime ?>;base64,<?= $logoBase64 ?>" alt="Logo" style="height: 50px;">
                <?php else : ?>
                    <p>Logo tidak ditemukan</p>
                <?php endif; ?>
            </td>
            <td class="title-cell">
                <h1 style="margin: 0;">Rekapan Absensi Bulan <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h1>
            </td>
        </tr>
    </table>

    <hr>

    <?php
    // Cek apakah data $rekapan tidak kosong
    if (!empty($rekapan)) {
        // Ambil semua nama karyawan yang ada di $rekapan
        $namaKaryawanList = array_unique(array_column($rekapan, 'nama_karyawan'));

        // Tentukan teks dinamis berdasarkan jumlah karyawan
        if (count($namaKaryawanList) == 1) {
            $teksLaporan = "Berikut ini adalah laporan rekapitulasi absensi bulanan untuk karyawan yang bersangkutan:";
        } else {
            $teksLaporan = "Berikut ini adalah laporan rekapitulasi absensi bulanan untuk seluruh karyawan:";
        }
    } else {
        $teksLaporan = "Data absensi tidak tersedia.";
    }
    ?>

    <h4><?= $teksLaporan ?></h4>

    <?php if (!empty($rekapan) && count($namaKaryawanList) == 1) : ?>
        <p><strong>Nama Karyawan:</strong> <?= $rekapan[0]['nama_karyawan'] ?></p>
    <?php elseif (!empty($rekapan) && count($namaKaryawanList) > 1) : ?>
        <p><strong>Nama Karyawan:</strong> Semua Karyawan</p>
    <?php else : ?>
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
                <td><?= $statusCount['Hadir'] ?? 0 ?></td>
            </tr>
            <tr>
                <td><strong>Sakit</strong></td>
                <td><?= $statusCount['Sakit'] ?? 0 ?></td>
            </tr>
            <tr>
                <td><strong>Izin</strong></td>
                <td><?= $statusCount['Izin'] ?? 0 ?></td>
            </tr>
            <tr>
                <td><strong>Terlambat</strong></td>
                <td><?= $statusCount['Terlambat'] ?? 0 ?></td>
            </tr>
            <!-- Tambahkan status lainnya jika ada -->
        </tbody>
    </table>

    <!-- Tabel detail absensi -->
    <table class="detail-absensi">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 130px;">Nama Karyawan</th>
                <th style="width: 80px;">Tanggal</th>
                <th style="width: 50px;">Sesi</th>
                <th style="width: 60px;">Status</th>
                <th style="width: 70px;">Keterangan</th>
            </tr>
        </thead>

        <tbody>
            <?php $i = 1;
            if (!empty($rekapan)) :
                foreach ($rekapan as $row) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['nama_karyawan']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                        <td><?= htmlspecialchars($row['sesi']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['keterangan']); ?></td>
                    </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>

</body>

</html>
