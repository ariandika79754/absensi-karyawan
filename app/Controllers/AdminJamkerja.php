<?php

namespace App\Controllers;

use App\Models\Admin\SesiModel;

class AdminJamkerja extends BaseController
{
    protected $sesiModel;
    protected $db;
    public function __construct()
    {
        $this->sesiModel = new SesiModel();
    }

    public function index()
    {

        $data = [
            'sesi' =>  $this->sesiModel->getAllSesi()
        ];
        echo view('konten/admin/sesi/index.php', $data);
    }
    // Add 
    public function add()
    {
        // dd($this->karyawanModel->getUsersById(session()->get('data')['id']));
        $data = [
            'sesi' => $this->sesiModel->getAllSesi()
        ];
        echo view('konten/admin/sesi/add.php', $data);
    }
    // Add Post
    public function save()
    {
        // Validasi data input
        $validation = $this->validate([
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'sesi'      => 'required|in_list[1,2]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data ke database
        $this->sesiModel->save([
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'sesi' => $this->request->getPost('sesi'),
        ]);

        // Redirect ke halaman daftar jam kerja dengan pesan sukses
        return redirect()->to('/admin/master/jam-kerja')->with('success', 'Data jam kerja berhasil disimpan.');
    }
    // Update
    public function edit($id)
    {
        $decodedId = decrypt_url($id); // Dekripsi ID
        $sesi = $this->sesiModel->find($decodedId);
    
        if (!$sesi) {
            return redirect()->to('/admin/master/jam-kerja')->with('error', 'Data tidak ditemukan.');
        }
    
        $data = [
            'sesi' => $sesi,
        ];
    
        return view('konten/admin/sesi/edit.php', $data);
    }
    
    public function update($id)
    {
        $decodedId = decrypt_url($id); // Dekripsi ID
    
        // Validasi data input
        $validation = $this->validate([
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'sesi'      => 'required|in_list[1,2]',
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Update data di database
        $this->sesiModel->update($decodedId, [
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'sesi' => $this->request->getPost('sesi'),
        ]);
    
        return redirect()->to('/admin/master/jam-kerja')->with('success', 'Data jam kerja berhasil diupdate.');
    }
    
    // Delete

    public function deleteJamKerja($id)
    {
        $this->sesiModel->delete(decrypt_url($id));
        session()->setFlashdata('error', 'Berhasil menghapus data.'); // tambahkan ini
        return redirect()->to('/admin/master/jam-kerja');
    }
}
