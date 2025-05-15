<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi Bulan <?= $namaBulan ?> <?= $tahun ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 95%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-align: center;
        }

        .info-karyawan {
            margin-bottom: 20px;
        }

        .info-karyawan p {
            margin: 4px 0;
        }

        h3 {
            text-align: center;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
        .no-border-table td {
    border: none !important;
    padding: 2px 0;
}
.no-border-table {
    border: none !important;
    border-collapse: collapse;
    font-size: 14px;
    margin-top: 10px;
}
.no-border-table td.separator {
    padding: 0 4px;
    width: 10px;
}

        .small-table-container {
            width: 60%;
            margin: 20px auto;
        }

        @media print {
            body {
                color: #000;
            }

            .container {
                page-break-inside: avoid;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <!-- <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Perusahaan"> -->
            <h1>Rekap Absensi Bulan <?= $namaBulan ?> <?= $tahun ?></h1>
        </div>

        <div class="info-karyawan">
    <h4>Berikut ini adalah laporan rekapitulasi absensi bulanan untuk karyawan yang bersangkutan:</h4>
    <table class="no-border-table">
    <tr>
        <td style="width: 180px;"><strong>Nama Karyawan</strong></td>
        <td class="separator">:</td>
        <td><?= !empty($rekap) ? $rekap[0]['nama_karyawan'] : 'Tidak ada data' ?></td>
    </tr>
    <tr>
        <td><strong>Nama Perusahaan</strong></td>
        <td class="separator">:</td>
        <td>PT Radar Lampung Visual (RadarTv)</td>
    </tr>
    <tr>
        <td><strong>Kabupaten / Provinsi</strong></td>
        <td class="separator">:</td>
        <td>Bandar Lampung / Lampung</td>
    </tr>
</table>


</div>


        <h3>Daftar Absensi</h3>
        <table>
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
                        <td colspan="4" style="text-align:center;">Tidak ada data absensi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>Status dan Jumlah</h3>
        <div class="small-table-container">
            <table>
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
                            <td colspan="2" style="text-align:center;">Tidak ada data status</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
