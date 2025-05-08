<?php

namespace App\Models\Karyawan;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'jabatan_id', 'alamat', 'no_hp', 'jenis_kelamin', 'status', 'foto', 'user_id'];

    public function getAllKaryawan()
    {
        return $this->findAll();
    }

    public function getKaryawanById($id)
    {
        // session berdasarkan id
        return $this->where("id", $id)->get()->getRow();
    }
    public function updateData($id, $data)
    {

        // Update data berdasarkan ID
        $this->set($data)->where('id', $id)->update();
    }
    public function insertData($data)
    {
        try {
            $this->insert($data);
            return true;  // Berhasil
        } catch (\Exception $e) {
            return false; // Gagal, tangani exception jika diperlukan
        }
    }
    public function getKaryawanByUserId($userId)
    {
        return $this->db->table('karyawan')
            ->select('karyawan.*, jabatan.jabatan AS jabatan')
            ->join('jabatan', 'jabatan.id = karyawan.jabatan_id', 'left') // sesuaikan kolom relasi
            ->where('karyawan.user_id', $userId)
            ->get()
            ->getRowArray();
    }


    public function updateByUserId($userId, $data)
    {
        return $this->where('user_id', $userId)->set($data)->update();
    }
}
