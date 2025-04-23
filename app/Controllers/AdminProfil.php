<?php

namespace App\Controllers;

use App\Models\Admin\UsersModel;

class AdminProfil extends BaseController
{
    protected $userModel;
    protected $db;
    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    public function index()
    {
        $username = session()->get('data')['username']; // Mengambil username dari session

        if ($username) {
            // Ambil pengguna berdasarkan username
            $data = [
                'users' => $this->userModel->getUsersByUsername($username)
            ];
            echo view('konten/admin/profil/index.php', $data);
        } else {
            return redirect()->to('/login'); // Jika tidak ada username di session, redirect ke login
        }
    }

    public function updatePelanggan()
    {
        // Ambil ID dari session
        $id = session()->get('data')['id'];
        // dd($id);
        // Ambil password dari input form
        $password = $this->request->getPost('password');

        // Data yang akan diupdate
        $data = [
            'role_id' => 1,
        ];

        // Jika password diisi, lakukan hashing dan tambahkan ke data update
        if (!empty($password)) {
            $data['password'] = hash('sha256', sha1($password)); // Kombinasi sha1 dan sha256
        }

        // Debugging data yang akan diupdate
        // dd($data, $id);

        // Update data pelanggan jika data tidak kosong
        if (!empty($data)) {
            $result = $this->userModel->updateData($id, $data); // Menggunakan ID dari session

            // Debug hasil query
            // dd($this->db->getLastQuery()->getQuery(), $result);

            if (!$result) {
                session()->setFlashdata('success', 'Berhasil mengubah data.');
                return redirect()->back();
            }
        }

        session()->setFlashdata('success', 'Berhasil mengubah data.');
        return redirect()->to('/admin/profile');
    }
}
