<?php

namespace App\Models\Karyawan;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'users_id',
        'tanggal',
        'sesi_id',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan'
    ];
    // protected $useTimestamps    = true; // akan otomatis isi created_at & updated_at

    // app/Models/AbsensiKaryawanModel.php

    public function getAllWithKaryawan($userId)
    {
        return $this->select('absensi.*, users.nama, sesi.sesi')
            ->join('users', 'users.id = absensi.users_id')
            ->join('sesi', 'sesi.id = absensi.sesi_id')
            ->where('absensi.users_id', $userId) // Filter berdasarkan session login
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }
    public function getRekapBulananByUser($usersId, $bulan, $tahun)
    {
        return $this->select('status, COUNT(*) as jumlah')
            ->where('users_id', $usersId)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->groupBy('status')
            ->findAll();
    }
    public function getRekapBulananByUsers($usersId, $bulan, $tahun)
    {
        return $this->db->table('absensi')
            ->select('absensi.tanggal, absensi.status, absensi.keterangan, users.nama as nama_karyawan, COUNT(*) as jumlah')
            ->join('users', 'users.id = absensi.users_id') // Assuming 'users' table and 'id' column for users
            ->where('absensi.users_id', $usersId)
            ->where('MONTH(absensi.tanggal)', $bulan)
            ->where('YEAR(absensi.tanggal)', $tahun)
            ->groupBy('absensi.tanggal, absensi.status, absensi.keterangan, users.nama')
            ->get()
            ->getResultArray();
    }
    


    // public function getMonthlyRecap($userId, $bulan, $tahun)
    // {
    //     return $this->db->table('absensi')
    //         ->select('status, COUNT(*) AS total')
    //         ->where('YEAR(tanggal)', $tahun)
    //         ->where('MONTH(tanggal)', $bulan)
    //         ->where('users_id', $userId)
    //         ->groupBy('status')
    //         ->get()
    //         ->getResultArray();
    // }
}
