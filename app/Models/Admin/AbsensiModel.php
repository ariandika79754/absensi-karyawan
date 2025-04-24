<?php

namespace App\Models\Admin;

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

public function getAllWithKaryawan()
{
    return $this->select('absensi.*, users.nama, sesi.sesi')
                ->join('users', 'users.id = absensi.users_id')
                ->join('sesi', 'sesi.id = absensi.sesi_id')
                ->orderBy('tanggal', 'DESC')
                ->findAll();
}

}
