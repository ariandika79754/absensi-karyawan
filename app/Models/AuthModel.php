<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    // protected $allowedFields = ['id', 'nip', 'nama',  'prodi_id', 'jurusan_id', 'email', 'ttd', 'status'];



    public function checkUser($username, $password)
    {

        // Hash yang pertama menggunakan algoritma sha-1
        // Hash yang kedua menggunakan algoritma sha256
        $hashedPassword = hash('sha256', sha1($password));

        // Query ke database untuk mencari user
        $user = $this->select('users.*, role.role') // Pilih kolom yang Anda butuhkan
            ->join('role', 'role.id = users.role_id', 'left') // Lakukan join dengan tabel role
            ->where('username', $username)
            ->where('password', $hashedPassword)
            ->first();

        if ($user) {
            // Jika user ditemukan, kembalikan data user
            return $user;
        }

        // Jika user tidak ditemukan, kembalikan null
        return null;
    }
}
