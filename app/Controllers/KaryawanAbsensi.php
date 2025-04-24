<?php

namespace App\Controllers;

use App\Models\Karyawan\AbsensiModel;
use App\Models\Admin\UsersModel;
use App\Models\Admin\SesiModel;

class KaryawanAbsensi extends BaseController
{
    protected $absensiModel;
    protected $sesiModel;
    protected $usersModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->sesiModel = new SesiModel();
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data = [
            'absensi' => $this->absensiModel->getAllWithKaryawan() // sesuaikan dengan method di model
        ];
        return view('konten/karyawan/absensi/index', $data);
    }

    // Tampilkan Form Tambah
    public function add()
    {
        $data = [
            'users' => $this->usersModel->where('role_id', 2)->findAll(),
            'sesi'  => $this->sesiModel->findAll(),
        ];
        return view('konten/karyawan/absensi/add', $data);
    }

    // Simpan Data Absensi
    public function save()
    {
        $validation = $this->validate([
            'users_id'   => 'required|numeric',
            'tanggal'    => 'required|valid_date',
            'sesi_id'    => 'required|numeric',
            'jam_masuk'  => 'required',
            'jam_keluar' => 'required',
            'status'     => 'required|in_list[Hadir,Izin,Sakit,Alfa]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->absensiModel->save([
            'users_id'   => $this->request->getPost('users_id'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'sesi_id'    => $this->request->getPost('sesi_id'),
            'jam_masuk'  => $this->request->getPost('jam_masuk'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'status'     => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/karyawan/absensi')->with('success', 'Data absensi berhasil disimpan.');
    }

    // Tampilkan Form Edit Absensi
    public function edit($id)
    {
        $decodedId = decrypt_url($id);
        $absensi = $this->absensiModel->find($decodedId);

        if (!$absensi) {
            return redirect()->to('/karyawan/absensi')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'absensi' => $absensi,
            'users'   => $this->usersModel->where('role_id', 2)->findAll(),
            'sesi'    => $this->sesiModel->findAll(),
        ];

        return view('konten/karyawan/absensi/edit', $data);
    }

    // Update Data Absensi
    public function update($id)
    {
        $decodedId = decrypt_url($id);

        $validation = $this->validate([
            'users_id'   => 'required|numeric',
            'tanggal'    => 'required|valid_date',
            'sesi_id'    => 'required|numeric',
            'jam_masuk'  => 'required',
            'jam_keluar' => 'required',
            'status'     => 'required|in_list[Hadir,Izin,Sakit,Alfa]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->absensiModel->update($decodedId, [
            'users_id'   => $this->request->getPost('users_id'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'sesi_id'    => $this->request->getPost('sesi_id'),
            'jam_masuk'  => $this->request->getPost('jam_masuk'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'status'     => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/karyawan/absensi')->with('success', 'Data absensi berhasil diupdate.');
    }

  


    // Delete

    public function deleteAbsensi($id)
    {
        $this->absensiModel->delete(decrypt_url($id));
        session()->setFlashdata('error', 'Berhasil menghapus data.'); // tambahkan ini
        return redirect()->to('/karyawan/master/jam-kerja');
    }
}
