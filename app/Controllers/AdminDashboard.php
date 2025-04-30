<?php

namespace App\Controllers;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $absensiModel = new \App\Models\Admin\AbsensiModel();

        // Statistik kehadiran semua user
        $data['hadir'] = $absensiModel->where('status', 'Hadir')->countAllResults();
        $data['izin'] = $absensiModel->where('status', 'Izin')->countAllResults();
        $data['alpha'] = $absensiModel->where('status', 'Alpha')->countAllResults();
        $data['sakit'] = $absensiModel->where('status', 'sakit')->countAllResults();

        // Grafik kehadiran 7 hari terakhir
        $today = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-6 days', strtotime($today)));

        $grafikData = $absensiModel->select("DATE(tanggal) as tanggal, COUNT(*) as jumlah")
            ->where('status', 'Hadir')
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $today)
            ->groupBy('DATE(tanggal)')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $grafikTanggal = [];
        $grafikJumlah = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            $grafikTanggal[] = date('D', strtotime($tanggal));
            $grafikJumlah[$tanggal] = 0;
        }

        foreach ($grafikData as $row) {
            $grafikJumlah[$row['tanggal']] = (int) $row['jumlah'];
        }

        $data['grafik'] = [
            'tanggal' => array_values($grafikTanggal),
            'hadir' => array_values($grafikJumlah)
        ];

        // Ambil semua data absensi 1 bulan terakhir
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
