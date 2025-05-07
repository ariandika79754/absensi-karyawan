<?php

namespace App\Controllers;

use App\Models\Admin\PenggajianModel;
use App\Models\Admin\AbsensiModel;
use App\Models\Admin\KaryawanModel;
use App\Models\Admin\UsersModel;

class AdminPenggajian extends BaseController
{
    protected $gajiModel;
    protected $absensiModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->gajiModel = new PenggajianModel();
        $this->absensiModel = new AbsensiModel();
        $this->karyawanModel = new KaryawanModel();
    }


    public function index()
    {
        $data = [
            'penggajian' => $this->gajiModel->getPenggajianIndex()
        ];
        // dd($data);
        echo view('konten/admin/penggajian/index.php', $data);
    }

    public function add()
    {
        $userModel = new UsersModel();
        $data['users'] = $userModel->findAll();
        return view('konten/admin/penggajian/add.php', $data);
    }

    public function save()
    {
        $users_id = $this->request->getPost('users_id');
        $bulan = $this->request->getPost('bulan');
        $jumlah_hadir = (int)$this->request->getPost('jumlah_hadir');

        // Ambil jabatan dan gaji bulanan
        $karyawanModel = new \App\Models\Admin\KaryawanModel();
        $jabatanModel = new \App\Models\Admin\JabatanModel();
        $karyawan = $karyawanModel->where('user_id', $users_id)->first();
        $jabatan = $jabatanModel->find($karyawan['jabatan_id']);

        $gaji_pokok = $jabatan['gaji_bulanan'];

        // Hitung total gaji
        $hari_kerja = $this->countWorkingDays($bulan);
        $gaji_per_hari = $gaji_pokok / $hari_kerja;
        $total_gaji = $gaji_per_hari * $jumlah_hadir;

        // Simpan data
        $penggajianModel = new PenggajianModel();
        $penggajianModel->save([
            'users_id'     => $users_id,
            'bulan'        => $bulan,
            'jumlah_hadir' => $jumlah_hadir,
            'total_gaji'   => $total_gaji,
            'gaji_pokok'   => $gaji_pokok,
        ]);

        return redirect()->to('/admin/penggajian')->with('success', 'Data penggajian berhasil ditambahkan.');
    }

    // Fungsi menghitung hari kerja (Senin–Sabtu, libur Minggu)
    private function countWorkingDays($bulan)
    {
        $date = new \DateTime($bulan . '-01');
        $daysInMonth = (int)$date->format('t');
        $workingDays = 0;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date->setDate((int)$date->format('Y'), (int)$date->format('m'), $i);
            $dayOfWeek = (int)$date->format('w');
            if ($dayOfWeek != 0) { // 0 = Minggu
                $workingDays++;
            }
        }

        return $workingDays;
    }

    public function getJumlahHadir()
    {
        $userId = $this->request->getGet('users_id');
        $bulan = $this->request->getGet('bulan'); // format: YYYY-MM

        $absensiModel = new \App\Models\Admin\AbsensiModel();
        $jumlahHadir = $absensiModel->where('users_id', $userId)
            ->like('tanggal', $bulan, 'after') // tanggal LIKE '2025-05%'
            ->where('status', 'hadir')
            ->countAllResults();

        return $this->response->setJSON(['jumlah_hadir' => $jumlahHadir]);
    }
}
