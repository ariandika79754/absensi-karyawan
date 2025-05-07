<?php

namespace App\Controllers;

use App\Models\Admin\JabatanModel;

class AdminJabatan extends BaseController
{
    protected $jabatanModel;
    protected $db;
    public function __construct()
    {
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {

        $data = [
            'jabatan' =>  $this->jabatanModel->getAllJabatan()
        ];
        echo view('konten/admin/jabatan/index.php', $data);
    }
    // Add 
    public function add()
    {
        // dd($this->karyawanModel->getUsersById(session()->get('data')['id']));
        $data = [
            'jabatan' => $this->jabatanModel->getAllJabatan()
        ];
        echo view('konten/admin/jabatan/add.php', $data);
    }
    // Add Post
    public function save()
    {
        // Validasi data input
        $validation = $this->validate([
            'jabatan' => 'required',
            // 'gaji_bulanan' => 'required', // Pastikan gaji adalah angka
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengambil input dan menghapus koma dari gaji_bulanan
        $jabatan = $this->request->getPost('jabatan');
        // $gajiBulanan = $this->request->getPost('gaji_bulanan');

        // // Menghapus koma dari gaji_bulanan
        // $gajiBulanan = str_replace('.', '', $gajiBulanan);

        // Simpan data ke database
        $this->jabatanModel->save([
            'jabatan' => $jabatan,
            // 'gaji_bulanan' => $gajiBulanan, // Gaji tanpa koma
        ]);

        // Redirect ke halaman daftar jabatan dengan pesan sukses
        return redirect()->to('/admin/master/jabatan')->with('success', 'Data jabatan berhasil disimpan.');
    }

    // Update
    public function edit($id)
    {
        $decodedId = decrypt_url($id); // Dekripsi ID
        $JabatanModel = $this->jabatanModel->find($decodedId);

        if (!$JabatanModel) {
            return redirect()->to('/admin/master/jabatan')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'jabatan' => $JabatanModel,
        ];

        return view('konten/admin/jabatan/edit.php', $data);
    }


    public function update($id)
    {
        $decodedId = decrypt_url($id); // Dekripsi ID

        // Validasi data input
        $validation = $this->validate([
            'jabatan' => 'required',
            // 'gaji_bulanan' => 'required',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data gaji bulanan dan hapus titik pemisah ribuan
        // $gajiBulanan = str_replace('.', '', $this->request->getPost('gaji_bulanan'));

        // Menyiapkan data yang akan diperbarui
        $data = [
            'jabatan' => $this->request->getPost('jabatan'),
            // 'gaji_bulanan' => $gajiBulanan, // Simpan tanpa titik
        ];

        // Simpan data ke database
        $this->jabatanModel->update($decodedId, $data); // Mengirim ID dan data yang sudah diperbarui

        // Redirect ke halaman daftar jabatan dengan pesan sukses
        return redirect()->to('/admin/master/jabatan')->with('success', 'Data jabatan berhasil diupdate.');
    }

    // Delete

    public function deleteJamKerja($id)
    {
        $this->jabatanModel->delete(decrypt_url($id));
        session()->setFlashdata('error', 'Berhasil menghapus data.'); // tambahkan ini
        return redirect()->to('/admin/master/jabatan');
    }
}
