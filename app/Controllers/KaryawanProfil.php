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
        $userId = session()->get('data')['id'];

        $userData = [
            'username' => $this->request->getPost('username'),
            'role_id' => 2, // Role ID karyawan
        ];

        if ($password = $this->request->getPost('password')) {
            $userData['password'] = hash('sha256', sha1($password));
        }

        // Ambil data karyawan
        $karyawan = $this->karyawanModel->where('user_id', $userId)->first();

        $karyawanData = [
            'nama' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        // Handle upload foto baru
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama kecuali default
            if (!empty($karyawan['foto']) && $karyawan['foto'] != 'default.png') {
                @unlink(FCPATH . 'uploads/karyawan/' . $karyawan['foto']);
            }

            $newName = $foto->getRandomName();
            $foto->move('uploads/karyawan', $newName);

            $karyawanData['foto'] = $newName;
        }
        // dd($userData, $karyawanData);
        $this->userModel->updateUser($userId, $userData);
        $this->karyawanModel->updateByUserId($userId, $karyawanData);

        session()->setFlashdata('success', 'Data profil berhasil diperbarui.');
        return redirect()->to('/karyawan/profil');
    }
}
