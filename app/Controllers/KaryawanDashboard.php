<?php

namespace App\Controllers;

use App\Models\Admin\AbsensiModel;

class KaryawanDashboard extends BaseController
{
    // public function index(): string
    // {
    //     return view('konten/karyawan/dashboard/index.php');
    // }

    public function index()
    {
        $absensiModel = new \App\Models\Admin\AbsensiModel();
        $userId = session()->get('data')['id']; // Ambil users_id dari session

        // Ringkasan berdasarkan users_id
        $bulanIniAwal = date('Y-m-01');
        $bulanIniAkhir = date('Y-m-t');

        $data['hadir'] = $absensiModel
            ->where('users_id', $userId)
            ->where('status', 'Hadir')
            ->where('tanggal >=', $bulanIniAwal)
            ->where('tanggal <=', $bulanIniAkhir)
            ->countAllResults();

        $data['izin'] = $absensiModel
            ->where('users_id', $userId)
            ->where('status', 'Izin')
            ->where('tanggal >=', $bulanIniAwal)
            ->where('tanggal <=', $bulanIniAkhir)
            ->countAllResults();

        $data['terlambat'] = $absensiModel
            ->where('users_id', $userId)
            ->where('status', 'Terlambat')
            ->where('tanggal >=', $bulanIniAwal)
            ->where('tanggal <=', $bulanIniAkhir)
            ->countAllResults();

        $data['sakit'] = $absensiModel
            ->where('users_id', $userId)
            ->where('status', 'sakit')
            ->where('tanggal >=', $bulanIniAwal)
            ->where('tanggal <=', $bulanIniAkhir)
            ->countAllResults();

        // Cek apakah user sudah absen hari ini
        $cekHariIni = $absensiModel->where('users_id', $userId)
            ->where('DATE(tanggal)', date('Y-m-d'))
            ->countAllResults();

        $data['belum_absen'] = ($cekHariIni == 0); // True jika belum absen

        // Grafik kehadiran 7 hari terakhir
        $today = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-6 days', strtotime($today)));

        $grafikData = $absensiModel->select("DATE(tanggal) as tanggal, COUNT(*) as jumlah")
            ->where('users_id', $userId)
            ->where('status', 'Hadir')
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $today)
            ->groupBy('DATE(tanggal)')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        // Siapkan data default 0 untuk 7 hari terakhir
        $grafikTanggal = [];
        $grafikJumlah = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            $grafikTanggal[] = date('D', strtotime($tanggal)); // e.g., "Mon", "Tue"
            $grafikJumlah[$tanggal] = 0;
        }

        // Masukkan hasil query ke array jumlah hadir
        foreach ($grafikData as $row) {
            $grafikJumlah[$row['tanggal']] = (int) $row['jumlah'];
        }

        $data['grafik'] = [
            'tanggal' => array_values($grafikTanggal),
            'hadir' => array_values($grafikJumlah)
        ];

        // Ambil data absensi 1 bulan terakhir untuk user
        $builder = $absensiModel->builder();
        $builder->select('absensi.*, users.nama');
        $builder->join('users', 'users.id = absensi.users_id');
        $builder->where('absensi.users_id', $userId);
        $builder->where('tanggal >=', date('Y-m-d', strtotime('-1 month')));
        $builder->orderBy('tanggal', 'DESC');
        $query = $builder->get();
        $data['absensi_terakhir'] = $query->getResultArray();

        return view('konten/karyawan/dashboard/index', $data);
    }
}
