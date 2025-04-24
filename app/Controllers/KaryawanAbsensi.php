<?php

namespace App\Controllers;

use App\Models\Karyawan\AbsensiModel;
use App\Models\Admin\UsersModel;
use App\Models\Admin\SesiModel;
use Dompdf\Options;
use Dompdf\Dompdf;
use \DateTime;


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
        $userId = session()->get('data')['id']; // Ambil ID pengguna dari session, sama seperti di profil
        // dd($userId);
        if ($userId) {
            $data = [
                'absensi' => $this->absensiModel->getAllWithKaryawan($userId)
            ];

            return view('konten/karyawan/absensi/index', $data);
        } else {
            return redirect()->to('/login');
        }
    }


    // Tampilkan Form Tambah
    public function add()
    {
        $userId = session()->get('data')['id'];

        if ($userId) {
            $userData = $this->usersModel->find($userId);
            $sesiData = $this->sesiModel->findAll(); // ambil sesi juga untuk ditampilkan

            $data = [
                'users' => $userData,
                'sesi' => $sesiData
            ];

            return view('konten/karyawan/absensi/add', $data);
        } else {
            return redirect()->to('/login');
        }
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


    public function rekapBulanan()
    {
        $absensiModel = new AbsensiModel();

        // Ambil users_id dari session (ganti kalau key session-nya beda)
        $usersId = session()->get('data')['id'];

        // Ambil bulan dan tahun dari GET, default ke bulan dan tahun sekarang
        $bulan = (int) $this->request->getGet('bulan') ?: date('n');
        $tahun = (int) $this->request->getGet('tahun') ?: date('Y');

        // Nama bulan untuk tampilan
        $bulanNama = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $namaBulan = $bulanNama[$bulan] ?? 'Tidak diketahui';

        // Query rekap berdasarkan users_id
        $rekap = $absensiModel->getRekapBulananByUser($usersId, $bulan, $tahun);
        // dd($rekap);
        return view('konten/karyawan/absensi/rekap', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => $namaBulan,
            'rekap' => $rekap,
        ]);
    }
    public function exportPdf()
    {
        $usersId = session()->get('data')['id'];
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        // Ambil data rekap
        $rekap = $this->absensiModel->getRekapBulananByUsers($usersId, $bulan, $tahun);

        // Set up Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        // Buat HTML untuk PDF
        $html = view('konten/karyawan/absensi/rekap-bulanan-pdf', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => DateTime::createFromFormat('!m', $bulan)->format('F')
        ]);

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran kertas (A4)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (mungkin memerlukan waktu sedikit)
        $dompdf->render();

        // Output PDF ke browser
        $dompdf->stream("rekap_absensi_{$bulan}_{$tahun}.pdf", ["Attachment" => 0]);
    }
    // public function rekapBulanan($tahun = null, $bulan = null)
    // {
    //     // Jika bulan atau tahun tidak disediakan, set ke nilai default
    //     $bulan = $bulan ?? date('m');
    //     $tahun = $tahun ?? date('Y');

    //     // Debugging untuk melihat nilai bulan dan tahun
    //     // dd($bulan, $tahun);

    //     // Ambil ID karyawan dari session
    //     $userId = session()->get('data')['id'];

    //     // Panggil model untuk mendapatkan rekap absensi berdasarkan bulan dan tahun
    //     $rekap = $this->absensiModel->getMonthlyRecap($userId, $bulan, $tahun);

    //     // Kirim data ke view
    //     return view('konten/karyawan/absensi/rekap', [
    //         'rekap' => $rekap,
    //         'bulan' => $bulan,
    //         'tahun' => $tahun,
    //     ]);
    // }
}
