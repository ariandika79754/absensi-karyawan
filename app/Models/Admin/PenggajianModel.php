<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class PenggajianModel extends Model
{
    protected $table = 'penggajian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'users_id',
        'bulan',
        'jumlah_hadir',
        'total_hari_kerja',
        'gaji_pokok',
        'potongan',
        'total_gaji',
        'dibuat_pada'
    ];
    public function getPenggajianWithNama()
    {
        // Mengambil data penggajian dengan join ke users, karyawan, jabatan dan absensi untuk jumlah hadir
        return $this->select('penggajian.*, users.nama, jabatan.gaji_bulanan AS gaji_pokok')
            ->join('users', 'users.id = penggajian.users_id')
            ->join('karyawan', 'karyawan.user_id = users.id')
            ->join('jabatan', 'jabatan.id = karyawan.jabatan_id')
            // Gabungkan absensi untuk menghitung jumlah hadir
            ->join('absensi', 'absensi.users_id = users.id AND DATE_FORMAT(absensi.tanggal, "%Y-%m") = DATE_FORMAT(penggajian.bulan, "%Y-%m")', 'left')
            ->select('COUNT(absensi.id) AS jumlah_hadir') // Menghitung jumlah absensi
            ->groupBy('penggajian.id') // Mengelompokkan berdasarkan penggajian ID
            ->findAll();
    }
    public function getPenggajianIndex()
    {
        return $this->select('penggajian.*, users.nama, jabatan.gaji_bulanan AS gaji_pokok')
            ->join('users', 'users.id = penggajian.users_id')
            ->join('karyawan', 'karyawan.user_id = users.id')
            ->join('jabatan', 'jabatan.id = karyawan.jabatan_id')
            ->findAll();
    }
}
