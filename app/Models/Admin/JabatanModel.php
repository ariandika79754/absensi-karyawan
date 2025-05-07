<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table      = 'jabatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['jabatan']; // Sesuaikan dengan struktur tabel Anda

   
    public function updateData($id, $data)
    {

        // Update data berdasarkan ID
        $this->set($data)->where('id', $id)->update();
    }

    public function getAllJabatan()
    {
        return $this->findAll();
    }
    public function getUsersByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // public function updateDataPelanggan($id, $data)
    // {
    //     return $this->where('id', $id)->set($data)->update();
    // }
    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }
}
