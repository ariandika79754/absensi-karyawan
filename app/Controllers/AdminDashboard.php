<?php

namespace App\Controllers;

use App\Models\Admin\AbsensiModel;
use App\Models\Admin\UsersModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $absensiModel = new AbsensiModel();
        $usersModel = new UsersModel();

        // Statistik kehadiran
        $data['hadir'] = $absensiModel->where('status', 'Hadir')->countAllResults();
        $data['izin'] = $absensiModel->where('status', 'Izin')->countAllResults();
        $data['terlambat'] = $absensiModel->where('status', 'Terlambat')->countAllResults();
        $data['sakit'] = $absensiModel->where('status', 'sakit')->countAllResults();

        // Jumlah karyawan dari tabel users
        // Mengambil jumlah karyawan dengan role 2
        $data['jumlah_karyawan'] = $usersModel->where('role_id', 2)->countAllResults();
        
        // Grafik kehadiran 7 hari terakhir
        $today = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-6 days', strtotime($today)));

        $grafikData = $absensiModel->select("DATE(tanggal) as tanggal, COUNT(*) as jumlah")
            ->where('status', 'Hadir')
            ->where("DATE(tanggal) >=", $startDate)
            ->where("DATE(tanggal) <=", $today)
            ->groupBy("DATE(tanggal)")
            ->orderBy("DATE(tanggal)", 'ASC')
            ->findAll();


        $grafikTanggal = [];
        $grafikJumlah = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            $grafikTanggal[] = date('D', strtotime($tanggal)); // tampilkan nama harinya
            $grafikJumlah[$tanggal] = 0; // inisialisasi jumlah hadir 0
        }

        // masukkan jumlah hadir sesuai tanggal
        foreach ($grafikData as $row) {
            $grafikJumlah[$row['tanggal']] = (int) $row['jumlah'];
        }

        // SAMAKAN URUTANNYA
        $grafikHadir = [];
        foreach (array_keys($grafikJumlah) as $tanggal) {
            $grafikHadir[] = $grafikJumlah[$tanggal];
        }

        $data['grafik'] = [
            'tanggal' => $grafikTanggal,  // ['Mon', 'Tue', ...]
            'hadir' => $grafikHadir       // [1, 0, 3, 0, 2, ...] sesuai urutan tanggal
        ];

        // dd($grafikData);
        // Riwayat absensi 1 bulan terakhir
        $builder = $absensiModel->builder();
        $builder->select('absensi.*, users.nama');
        $builder->join('users', 'users.id = absensi.users_id');
        $builder->where('tanggal >=', date('Y-m-d', strtotime('-1 month')));
        $builder->orderBy('tanggal', 'DESC');
        $query = $builder->get();
        $data['absensi_terakhir'] = $query->getResultArray();

        return view('konten/admin/dashboard/index', $data);
    }
}
