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

    $usernameBaru = $this->request->getPost('username');
    $namaBaru = $this->request->getPost('nama');

    // Cek username sudah dipakai user lain atau belum
    $cekUsername = $this->userModel
        ->where('username', $usernameBaru)
        ->where('id !=', $userId)
        ->first();

    if ($cekUsername) {
        session()->setFlashdata('error', 'Username sudah digunakan oleh pengguna lain.');
        return redirect()->back()->withInput();
    }

    // Cek nama sudah dipakai user lain atau belum (kalau memang harus unik)
    $cekNama = $this->userModel
        ->where('nama', $namaBaru)
        ->where('id !=', $userId)
        ->first();

    if ($cekNama) {
        session()->setFlashdata('error', 'Nama sudah digunakan oleh pengguna lain.');
        return redirect()->back()->withInput();
    }

    $userData = [
        'username' => $usernameBaru,
        'email' => $this->request->getPost('email'),
        'role_id' => 2, // Role ID karyawan
        'nama' => $namaBaru,
    ];

    if ($password = $this->request->getPost('password')) {
        $userData['password'] = hash('sha256', sha1($password));
    }

    // Ambil data karyawan
    $karyawan = $this->karyawanModel->where('user_id', $userId)->first();

    $karyawanData = [
        'nama' => $namaBaru,
        'no_hp' => $this->request->getPost('no_hp'),
        'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
        'alamat' => $this->request->getPost('alamat'),
    ];

    // Handle upload foto baru
    $foto = $this->request->getFile('foto');
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        if (!empty($karyawan['foto']) && $karyawan['foto'] != 'default.png') {
            @unlink(FCPATH . 'uploads/karyawan/' . $karyawan['foto']);
        }

        $newName = $foto->getRandomName();
        $foto->move('uploads/karyawan', $newName);

        $karyawanData['foto'] = $newName;
    }

    // Update data users dan karyawan
    $this->userModel->updateUser($userId, $userData);
    $this->karyawanModel->updateByUserId($userId, $karyawanData);

    session()->setFlashdata('success', 'Data profil berhasil diperbarui.');
    return redirect()->to('/karyawan/profil');
}


}
