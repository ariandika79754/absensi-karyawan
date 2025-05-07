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
        // Ambil data jabatan dari model JabatanModel
        $jabatanModel = new \App\Models\Admin\JabatanModel();
        $jabatanList = $jabatanModel->findAll(); // Menyimpan semua data jabatan

        // Ambil semua data karyawan
        $data = [
            'jabatanList' => $jabatanList, // Mengirimkan data jabatan ke view
            'karyawan' => $this->karyawanModel->getAllKaryawan()
        ];

        echo view('konten/admin/karyawan/add.php', $data);
    }
    public function save()
    {
        // // Validasi input
        // if (!$this->validate([
        //     'nama'          => 'required',
        //     'tanggal_lahir' => 'required|valid_date',
        //     'jabatan'       => 'required',
        //     'alamat'        => 'required',
        //     'no_hp'         => 'required',
        //     'jenis_kelamin' => 'required',
        //     'status'        => 'required',
        //     'foto'          => 'uploaded[foto]|max_size[foto,4096]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
        // ])) {
        //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        // }

        // Handle uploaded file foto
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/karyawan', $namaFoto);
        }

        // Data karyawan
        $nama = $this->request->getPost('nama');
        $tanggalLahir = $this->request->getPost('tanggal_lahir');

        // Buat akun user untuk karyawan
        $userModel = new \App\Models\Admin\UsersModel();
        $username = strtolower(str_replace(' ', '', $nama)); // Username tanpa spasi
        $passwordDate = date('dmY', strtotime($tanggalLahir)); // Format: tanggal-bulan-tahun
        $password = $passwordDate;

        $userData = [
            'username' => $username,
            'nama' => $nama,
            'role_id' => 2, // Misal: 2 untuk karyawan
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
            'jabatan_id'       => $this->request->getPost('jabatan_id'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status'        => $this->request->getPost('status'),
            'foto'          => $namaFoto ?? null,
            'user_id'       => $userId, // Masukkan user_id yang baru saja dibuat
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
        $jabatanModel = new \App\Models\Admin\JabatanModel();
        $jabatanList = $jabatanModel->findAll(); // Menyimpan semua data jabatan

        // Ambil semua data karyawan
        $data = [
            'jabatanList' => $jabatanList, // Mengirimkan data jabatan ke view
            'karyawan' => $karyawan
        ];

        echo view('konten/admin/karyawan/edit.php', $data);
    }

    public function update($id)
    {
        $id = decrypt_url($id); // Dekripsi ID

        // $validation = $this->validate([
        //     'nama'          => 'required',
        //     'jabatan'       => 'required',
        //     // 'alamat'        => 'required',
        //     // 'no_hp'         => 'required',
        //     // 'jenis_kelamin' => 'required',
        //     'status'        => 'required',
        //     // 'foto'          => 'if_exist|uploaded[foto]|max_size[foto,4096]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
        // ]);

        // if (!$validation) {
        //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        // }

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
            'jabatan_id'       => $this->request->getPost('jabatan_id'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status'        => $this->request->getPost('status'),
            'foto'          => $namaFoto ?? $this->request->getPost('old_foto'),
        ]);

        // Update juga di tabel users
        $namaBaru = $this->request->getPost('nama');
        $karyawan = $this->karyawanModel->find($id);

        $userModel = new \App\Models\Admin\UsersModel();
        $userModel->update($karyawan['user_id'], [
            'nama' => $namaBaru
        ]);

        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan dan user berhasil diperbarui.');
    }

    public function deleteKaryawan($id)
    {
        $id = decrypt_url($id);

        // Ambil data karyawan terlebih dahulu untuk mendapatkan user_id dan foto
        $karyawan = $this->karyawanModel->find($id);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan.');
            return redirect()->to('/admin/karyawan');
        }

        // Hapus foto dari folder jika ada
        if ($karyawan['foto'] && file_exists('uploads/karyawan/' . $karyawan['foto'])) {
            unlink('uploads/karyawan/' . $karyawan['foto']);
        }

        // Hapus akun user yang terkait
        $userModel = new \App\Models\Admin\UsersModel();
        $userModel->delete($karyawan['user_id']);

        // Hapus data karyawan
        $this->karyawanModel->delete($id);

        session()->setFlashdata('error', 'Berhasil menghapus data.');
        return redirect()->to('/admin/karyawan');
    }
}
