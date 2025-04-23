<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class SesiModel extends Model
{
    protected $table      = 'sesi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['jam_masuk', 'jam_keluar', 'sesi']; // Sesuaikan dengan struktur tabel Anda

    public function updatePassword($id, $newPassword)
    {
        // Sesuaikan metode hash sesuai kebutuhan
        $hashedPassword = hash('sha256', sha1($newPassword));
        $this->set(['password' => $hashedPassword])
            ->where('id', $id)
            ->update();
    }
    public function getAlluser()
    {
        return  $this->db->table('users')
        ->select('users.id, users.username, users.nama, role.role as role')
        ->join('role', 'users.role_id = role.id')
        ->where('users.role_id', 2) // Filter di sini hanya mengambil role_id = 2
        ->get()
        ->getResultArray();
    }

    public function updateData($id, $data)
    {

        // Update data berdasarkan ID
        $this->set($data)->where('id', $id)->update();
    }

    public function getAllSesi()
    {
        return $this->findAll();
    }

    public function getUsersById($id)
    {

        return $this->where("id", $id)->get()->getRow();
    }
    public function updateDataPelanggan($id, $data)
{
    return $this->where('id', $id)->set($data)->update();
}

    
}
