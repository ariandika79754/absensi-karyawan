<?php

namespace App\Controllers;

use App\Models\Admin\UsersModel;
use App\Models\Karyawan\KaryawanModel;

class KaryawanProfil extends BaseController
{
    protected $userModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
        $this->karyawanModel = new KaryawanModel();
    }
    public function index()
    {
        $userId = session()->get('data')['id']; // Ambil ID pengguna dari session
    // dd($userId);
        if ($userId) {
            // Ambil data pengguna dan karyawan berdasarkan user_id
            $userData = $this->userModel->find($userId);
            $karyawanData = $this->karyawanModel->getKaryawanByUserId($userId);
    
            if ($userData) {
                $data = [
                    'users' => $userData,
                    'karyawan' => $karyawanData
                ];
    
                echo view('konten/karyawan/profil/index.php', $data);
            } else {
                return redirect()->to('/login'); // Jika data tidak ditemukan, redirect ke login
            }
        } else {
            return redirect()->to('/login'); // Jika tidak ada ID di session, redirect ke login
        }
    }
    
    public function update()
    {
        $id = session()->get('data')['id'];
        $password = $this->request->getPost('password');

        $data = [
            'role_id' => 1,
        ];

        if (!empty($password)) {
            $data['password'] = hash('sha256', sha1($password));
        }

        $result = $this->userModel->updateData($id, $data);

        if ($result) {
            session()->setFlashdata('success', 'Berhasil mengubah data.');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah data.');
        }

        return redirect()->to('/admin/profile');
    }
}
