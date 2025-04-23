<?php

namespace App\Controllers;

use App\Models\Admin\UsersModel;

class AdminUsers extends BaseController
{
    protected $userModel;
    protected $db;
    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    public function index()
    {

        $data = [
            'users' =>  $this->userModel->getAlluser()
        ];
        echo view('konten/admin/users/index.php', $data);
    }

    // Menampilkan form tambah data
    public function add()
    {
        echo view('konten/admin/users/add.php');
    }

    // Menyimpan data pengguna baru
    public function save()
    {
        // Validasi input
        $validation = $this->validate([
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah tersedia.'
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ],
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ],
            ],
        ]);

        // Jika validasi gagal
        if (!$validation) {
            // Debugging error
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // Jika validasi berhasil
        $password = $this->request->getPost('password');
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => hash('sha256', sha1($password)),
            'nama'     => $this->request->getPost('nama'),
            'role_id'  => 2 // Set role_id menjadi 2
        ];

        // Simpan data ke database
        $this->userModel->save($data);

        // Set flash message sukses
        session()->setFlashdata('success', 'Data pengguna berhasil ditambahkan.');
        return redirect()->to('/admin/master/users');
    }

    public function edit($id)
    {
        $id = decrypt_url($id); // Dekripsi ID
        $users = $this->userModel->find($id);

        if (!$users) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('users tidak ditemukan.');
        }

        $data = [
            'user' => $users
        ];

        echo view('konten/admin/users/edit.php', $data);
    }

    public function update($id)
    {
        // Ambil data user berdasarkan ID
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan.');
        }

        // Validasi input
        $validation = $this->validate([
            'username' => [
                'rules' => "required|is_unique[users.username,id,{$id}]",
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah tersedia.'
                ],
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter.'
                ],
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ],
            ],
        ]);

        if (!$validation) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // Update data
        $password = $this->request->getPost('password');
        $data = [
            'username' => $this->request->getPost('username'),
            'nama'     => $this->request->getPost('nama'),
        ];

        // Jika password diisi, hash password baru
        if (!empty($password)) {
            $data['password'] = hash('sha256', sha1($password));
        }

        $this->userModel->update($id, $data);

        session()->setFlashdata('success', 'Data pengguna berhasil diperbarui.');
        return redirect()->to('/admin/master/users');
    }


    // Delete

    public function deleteUsers($id)
    {
        $this->userModel->delete(decrypt_url($id));
        session()->setFlashdata('error', 'Berhasil menghapus data.'); // tambahkan ini
        return redirect()->to('/admin/users');
    }
}
