<?php

namespace App\Controllers;

use App\Models\Admin\KaryawanModel;

class AdminKaryawan extends BaseController
{
    protected $karyawanModel;
    protected $db;
    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel();
    }

    public function index()
    {
        // dd($this->karyawanModel->getUsersById(session()->get('data')['id']));
        $data = [
            'karyawan' => $this->karyawanModel->getAllKaryawan()
        ];
        echo view('konten/admin/karyawan/index.php', $data);
    }
    public function add()
    {
        // dd($this->karyawanModel->getUsersById(session()->get('data')['id']));
        $data = [
            'karyawan' => $this->karyawanModel->getAllKaryawan()
        ];
        echo view('konten/admin/karyawan/add.php', $data);
    }
    public function save()
    {
        $validation = $this->validate([
            'nama'          => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'jabatan'       => 'required',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'jenis_kelamin' => 'required',
            'status'        => 'required',
            'foto'          => 'uploaded[foto]|max_size[foto,4096]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle uploaded file
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/karyawan', $namaFoto);
        }

        // Data karyawan
        $nama = $this->request->getPost('nama');
        $tanggalLahir = $this->request->getPost('tanggal_lahir');

        // Buat akun user
        $userModel = new \App\Models\Admin\UsersModel();
        $username = strtolower(str_replace(' ', '', $nama)); // Username tanpa spasi
        $passwordDate = date('dmY', strtotime($tanggalLahir)); // Format: tanggal-bulan-tahun
        $password = $passwordDate;
        // Password dalam format Tahun/bulan/tanggal;

        $userData = [
            'username' => $username,
            'nama' => $nama,
            'role_id'  => 2, // Misal: 2 untuk karyawan
        ];

        if (!empty($password)) {
            $userData['password'] = hash('sha256', sha1($password)); // Hash password
        }

        $userModel->save($userData);

        // Dapatkan user_id dari pengguna yang baru dibuat
        $userId = $userModel->getInsertID(); // Ambil ID terakhir yang di-insert

        // Simpan data karyawan
        $this->karyawanModel->save([
            'nama'          => $nama,
            'tanggal_lahir' => $tanggalLahir,
            'jabatan'       => $this->request->getPost('jabatan'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status'        => $this->request->getPost('status'),
            'foto'          => $namaFoto ?? null,
            'user_id'       => $userId, // Masukkan user_id
        ]);

        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil disimpan dan akun user berhasil dibuat.');
    }

    public function edit($id)
    {
        $id = decrypt_url($id); // Dekripsi ID
        $karyawan = $this->karyawanModel->find($id);

        if (!$karyawan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Karyawan tidak ditemukan.');
        }

        $data = [
            'karyawan' => $karyawan
        ];

        echo view('konten/admin/karyawan/edit.php', $data);
    }

    public function update($id)
    {
        $id = decrypt_url($id); // Dekripsi ID

        $validation = $this->validate([
            'nama'          => 'required',
            'jabatan'       => 'required',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'jenis_kelamin' => 'required',
            'status'        => 'required',
            'foto'          => 'if_exist|uploaded[foto]|max_size[foto,4096]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        // Update foto jika ada file yang diunggah
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/karyawan', $namaFoto);

            // Hapus foto lama
            $karyawan = $this->karyawanModel->find($id);
            if ($karyawan['foto'] && file_exists('uploads/karyawan/' . $karyawan['foto'])) {
                unlink('uploads/karyawan/' . $karyawan['foto']);
            }
        }

        $this->karyawanModel->update($id, [
            'nama'          => $this->request->getPost('nama'),
            'jabatan'       => $this->request->getPost('jabatan'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status'        => $this->request->getPost('status'),
            'foto'          => $namaFoto ?? $this->request->getPost('old_foto'),
        ]);

        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function deleteKaryawan($id)
    {
        $this->karyawanModel->delete(decrypt_url($id));
        session()->setFlashdata('error', 'Berhasil menghapus data.'); // tambahkan ini
        return redirect()->to('/admin/karyawan');
    }
}
