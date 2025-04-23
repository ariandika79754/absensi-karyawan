<?php

// Import namespace yang diperlukan
use Config\Database;

// Fungsi untuk memeriksa keberadaan data di tabel kelas_detail
function isMahasiswaAddedToKelas($kelasMasterId, $mahasiswaId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('kelas_detail')
        ->where('kelas_master_id', $kelasMasterId)
        ->where('mahasiswa_id', $mahasiswaId)
        ->countAllResults();

    // Hasilnya true jika data ditemukan, false jika tidak
    return $result > 0;
}
function isPlanning($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->get()->getNumRows();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function isPlanningVerif($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('verifikasi', 2)
        ->get()->getNumRows();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getRencanaByJadwal($jadwalId, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')
        ->select('rencana_perkuliahan.*, rencana_perkuliahan.id as rencana_perkuliahan_id')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('rencana_perkuliahan.tanggal', $tanggal)
        ->where('verifikasi', 2)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function SudahIsiRencanaBelum($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')->select('rencana_perkuliahan.*, rencana_perkuliahan.id as rencana_perkuliahan_id')
        ->where('jadwal_kuliah_id', $jadwalId)
        // ->where('rencana_perkuliahan.tanggal', $tanggal)
        // ->where('verifikasi', 2)
        // ->orderBy('rencana_perkuliahan.pertemuan')
        ->countAllResults();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getRencanaByJadwalDosen($jadwalId, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Get the current date and time in Jakarta time zone
    $currentDateTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
    $currentDateTimeStr = $currentDateTime->format('H:i:s');

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')
        ->select('rencana_perkuliahan.*, rencana_perkuliahan.id as rencana_perkuliahan_id')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('rencana_perkuliahan.tanggal', $tanggal)
        ->where('rencana_perkuliahan.jam_mulai <=', $currentDateTimeStr)
        ->where('rencana_perkuliahan.jam_selesai >=', $currentDateTimeStr)
        ->where('verifikasi', 2)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();

    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getRencanaByJadwalFix($jadwal, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Get the current date and time in Jakarta time zone
    $currentDateTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
    $currentDateTimeStr = $currentDateTime->format('H:i:s');

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')
        ->select('rencana_perkuliahan.*, rencana_perkuliahan.id as rencana_perkuliahan_id')
        ->where('rencana_perkuliahan.jadwal_kuliah_id', $jadwal)
        ->where('rencana_perkuliahan.tanggal', $tanggal)
        ->where('rencana_perkuliahan.jam_mulai <=', $currentDateTimeStr)
        ->where('rencana_perkuliahan.jam_selesai >=', $currentDateTimeStr)
        ->where('verifikasi', 2)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();

    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}

function getRencanKosong($jadwalId, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('rencana_perkuliahan.tanggal <', $tanggal)
        // ->where('verifikasi', 2)
        ->whereNotIn('rencana_perkuliahan.id', function ($subquery) {
            $subquery->select('rencana_perkuliahan_id')
                ->from('absensi');
        })
        ->get()->getRow();

    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getRencanPerubahanKosong($jadwalId, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.tanggal, perubahan_rencana.jam_mulai, perubahan_rencana.jam_selesai, perubahan_rencana.rencana_perkuliahan_id, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('perubahan_rencana.tanggal =', $tanggal)
        // ->where('verifikasi', 2)
        ->whereNotIn('rencana_perkuliahan.id', function ($subquery) {
            $subquery->select('rencana_perkuliahan_id')
                ->from('absensi');
        })
        ->get()->getRow();

    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getRencanKosongResult($jadwalId, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    date_default_timezone_set('Asia/Jakarta');

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('rencana_perkuliahan')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('rencana_perkuliahan.tanggal <', $tanggal)
        ->where('verifikasi', 2)
        ->whereNotIn('rencana_perkuliahan.id', function ($subquery) {
            $subquery->select('rencana_perkuliahan_id')
                ->from('absensi');
        })
        ->orWhere(
            "rencana_perkuliahan.id IN (
                SELECT rencana_perkuliahan_id 
                FROM perubahan_rencana 
                WHERE tanggal = '" . date('Y-m-d') . "' 
                AND jam_mulai < '" . date('H:i:s') . "' 
                AND jam_selesai > '" . date('H:i:s') . "'
                AND jadwal_kuliah_id = '" . $jadwalId . "'
            )"
        )
        // ->groupBy('rencana_perkuliahan.id')
        ->orderBy('pertemuan', 'DESC')
        ->get()->getResultArray();

    // Hasilnya dalam bentuk array jika data ditemukan, array kosong jika tidak
    return $result;
}



function sudahAdaJadwalNyaBelum($kelas)
{
    // Ambil koneksi database
    $db = Database::connect();
    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_kuliah')
        ->where('kelas_master_id', $kelas)
        ->get()->getNumRows();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function jumlahMatkul($kelas, $kurikulum = null)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $prodiId = session()->get('data')['prodi_id'];

    // Query SQL dengan penambahan kondisi untuk kurikulum
    $query = "
    SELECT nama_mk, sks_teori AS sks, 'teori' AS jenis_sks, id
    FROM matakuliah
    WHERE prodi_id = '$prodiId' 
      AND semester = '$kelas' 
      AND sks_teori > 0 ";

    if ($kurikulum !== null) {
        $query .= "AND matakuliah.kurikulum_id = '$kurikulum' ";
    } else {
        $query .= "AND matakuliah.kurikulum_id IS NULL ";
    }

    $query .= "
    UNION
    
    SELECT nama_mk, sks_praktik AS sks, 'praktik' AS jenis_sks, id
    FROM matakuliah
    WHERE prodi_id = '$prodiId' 
      AND semester = '$kelas' 
      AND sks_praktik > 0 ";

    if ($kurikulum !== null) {
        $query .= "AND matakuliah.kurikulum_id = '$kurikulum' ";
    } else {
        $query .= "AND matakuliah.kurikulum_id IS NULL ";
    }

    $query .= "ORDER BY nama_mk";

    // Jalankan query dan dapatkan jumlah baris
    $result = $db->query($query)->getNumRows();

    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}

function jumlahMatkulFlek($kelas, $prodiId)
{
    // Ambil koneksi database
    $db = Database::connect();
    // Pengecekan keberadaan data di tabel kelas_detail
    // $prodiId = session()->get('data')['prodi_id'];
    $result = $db->query("
    SELECT nama_mk, sks_teori AS sks, 'teori' AS jenis_sks, id
    FROM matakuliah
    WHERE prodi_id = '$prodiId' AND semester = '$kelas' AND sks_teori > 0 
    
    UNION
    
    SELECT nama_mk, sks_praktik AS sks, 'praktik' AS jenis_sks, id
    FROM matakuliah
    WHERE prodi_id = '$prodiId' AND semester = '$kelas' AND sks_praktik > 0 

    ORDER BY nama_mk
")->getNumRows();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}

function getDosenPJByJadwal($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('dosen.nip, dosen.nama as nama_dosen, dosen.id')
        ->join('dosen', 'jadwal_kuliah_dosen.dosen_id = dosen.id')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('jadwal_kuliah_dosen.status', 'pj')
        ->get()->getResultArray();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getDosenNOTPJByJadwal($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('dosen.nip, dosen.nama as nama_dosen, dosen.id')
        ->join('dosen', 'jadwal_kuliah_dosen.dosen_id = dosen.id')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->where('jadwal_kuliah_dosen.status', 'pengampu')
        ->get()->getResultArray();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getDosenByJadwal($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('dosen.nip, dosen.nama as nama_dosen, jadwal_kuliah_dosen.id, jadwal_kuliah_dosen.status, dosen_id')
        ->join('dosen', 'jadwal_kuliah_dosen.dosen_id = dosen.id')
        ->where('jadwal_kuliah_id', $jadwalId)
        ->orderBy('jadwal_kuliah_dosen.status', 'DESC')
        ->get()->getResultArray();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getDosenByJadwalPJ($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('dosen.nip, dosen.nama as nama_dosen, jadwal_kuliah_dosen.id, jadwal_kuliah_dosen.status, dosen_id')
        ->join('dosen', "jadwal_kuliah_dosen.dosen_id = dosen.id AND jadwal_kuliah_dosen.status = 'PJ'")
        ->where('jadwal_kuliah_id', $jadwalId)
        ->orderBy('jadwal_kuliah_dosen.status', 'DESC')
        ->get()->getResultArray();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getDosenByJadwalUas($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_uas_dosen')
        ->select('dosen.nip, dosen.nama as nama_dosen, jadwal_uas_dosen.id, jadwal_uas_dosen.status, dosen_id')
        ->join('dosen', 'jadwal_uas_dosen.dosen_id = dosen.id')
        ->where('jadwal_uas_id', $jadwalId)
        ->orderBy('jadwal_uas_dosen.status', 'DESC')
        ->get()->getResultArray();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}

function getAbsensiByJadwal($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('rencana_perkuliahan.verifikasi', 2)
        ->where('rencana_perkuliahan.tanggal', $tanggal)->get()->getRow();
    return $result;
}
function getAbsensiByJadwalDosen($rencana, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('rencana_perkuliahan.id', $rencana)
        ->where('rencana_perkuliahan.verifikasi', 2)
        ->where('rencana_perkuliahan.tanggal', $tanggal)->get()->getRow();
    return $result;
}

function sudahMelaksanakanAbsensiMahasiswa($rencana)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->where('absensi.rencana_perkuliahan_id', $rencana)->get()->getRow();
    return $result;
}
function sudahMelaksanakanAbsensiMahasiswa2($rencana)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->where('absensi.rencana_perkuliahan_id', $rencana)
        ->where('absensi_mahasiswa.mahasiswa_id', session()->get('data')['id'])
        ->get()->getRow();
    return $result;
}

function getAbsenApelMahasiswa($mahasiswa, $rencana_id)
{
    $db =  Database::connect();
    $result = $db->table('apel_pelaksanaan')
        ->select('apel_pelaksanaan.*')
        ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->join('apel_rencana', 'apel.apel_rencana_id = apel_rencana.id')
        ->where('apel_rencana.id', $rencana_id)->where('apel_pelaksanaan.mahasiswa_id', $mahasiswa)
        ->get()->getRow();
    return $result;
}

// DASHBORD MAHASISWA
function getJumlahKehadiran($jadwal, $mahasiswa, $kehadiran)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal)
        ->where('absensi_mahasiswa.mahasiswa_id', $mahasiswa)
        ->where('absensi_mahasiswa.kehadiran', $kehadiran)
        ->countAllResults();
    return $result;
}

// DASHBORD DOSEN
function getJumlahKehadiranDosen($jadwal)
{
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi_mahasiswa.*')
        ->join('absensi_mahasiswa', 'absensi.id = absensi_mahasiswa.absensi_id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal)->groupBy('absensi.id')
        ->countAllResults();
    return $result;
}
// Laporan
function KehadiranDosen($where)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('absensi_dosen.*')
        ->join('absensi', 'absensi.id = absensi_dosen.absensi_id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where($where)->groupBy('absensi.id')
        ->get()->getRow();
    return $result;
}
function KehadiranDosenCount($where)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('absensi_dosen.*')
        ->join('absensi', 'absensi.id = absensi_dosen.absensi_id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where($where)->groupBy('absensi.id')
        ->countAllResults();
    return $result;
}



// Matrik Dosen


function scoreMatrikDosen($ta, $matkul)
{
    $db = Database::connect();
    $result = $db->table('matrik_nilai')
        ->select('sum(matrik_kompetensi.nilai) as score')
        ->join('matrik_kompetensi', 'matrik_nilai.matrik_kompetensi_id=matrik_kompetensi.id')
        ->where([
            'matrik_nilai.tahun_akademik_id' => $ta,
            'matrik_nilai.dosen_id' => session()->get('data')['id'],
            'matrik_nilai.matakuliah_id' => $matkul,
        ])
        // ->groupBy('matrik_nilai.tahun_akademik_id')
        ->groupBy('matrik_nilai.dosen_id')
        ->get()->getRow();

    return $result;
}

function sudahPPBelumByJadwal($id, $mahasiswa)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*, rencana_perkuliahan.pertemuan')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $id)
        ->where('absensi_mahasiswa.mahasiswa_id', $mahasiswa)
        ->where('absensi_mahasiswa.kehadiran !=', 'H')
        // ->where('jadwal_kuliah.jenis_jadwal', 'praktik')
        // ->where('jadwal_kuliah.jenis_jadwal', 'praktik')
        ->whereNotIn('absensi_mahasiswa.id', function ($builder) {
            // Subquery to get absensi_mahasiswa_id from p_pengganti_detail
            $builder->select('absensi_mahasiswa_id')
                ->from('p_pengganti_detail')
                ->where('status', 1); // Tambahkan kondisi status
        })
        ->groupBy('rencana_perkuliahan.pertemuan')
        ->get()->getResult();
    return $result;
}










function getKelasDosenWali($mahasiswa_id, $ta)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('kelas_detail')
        ->select('kelas_detail.kelas_master_id')
        ->join('kelas_master', 'kelas_detail.kelas_master_id = kelas_master.id')
        ->where('kelas_detail.mahasiswa_id', $mahasiswa_id)
        ->where('kelas_master.tahun_akademik_id', $ta)->get()->getRow();
    return $result;
}

function getAbsensiByJadwalPerubahan($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('perubahan_rencana', 'rencana_perkuliahan.id = perubahan_rencana.rencana_perkuliahan_id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('perubahan_rencana.verifikasi', 1)
        ->where('perubahan_rencana.tanggal', $tanggal)->get()->getRow();
    return $result;
}
function getAbsensiByJadwalPerubahanDosen($rencanaId, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('perubahan_rencana', 'rencana_perkuliahan.id = perubahan_rencana.rencana_perkuliahan_id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('rencana_perkuliahan.id', $rencanaId)
        ->where('perubahan_rencana.verifikasi', 1)
        ->where('perubahan_rencana.tanggal', $tanggal)->get()->getRow();
    return $result;
}
function getAbsensiByJadwalCount($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('rencana_perkuliahan.verifikasi', 2)
        ->where('rencana_perkuliahan.tanggal', $tanggal)->countAllResults();
    return $result;
}
function getAbsensiByJadwalCountDosen($rencana, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('rencana_perkuliahan.id', $rencana)
        ->where('rencana_perkuliahan.verifikasi', 2)
        ->where('rencana_perkuliahan.tanggal', $tanggal)->countAllResults();
    return $result;
}
function getAbsensiByJadwalCountPerubahan($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('perubahan_rencana', 'rencana_perkuliahan.id = perubahan_rencana.rencana_perkuliahan_id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('perubahan_rencana.verifikasi', 1)
        ->where('perubahan_rencana.tanggal', $tanggal)->countAllResults();
    return $result;
}
function getAbsensiByJadwalCountPerubahanDosen($rencana, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('perubahan_rencana', 'rencana_perkuliahan.id = perubahan_rencana.rencana_perkuliahan_id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('rencana_perkuliahan.id', $rencana)
        ->where('perubahan_rencana.verifikasi', 1)
        ->where('perubahan_rencana.tanggal', $tanggal)->countAllResults();
    return $result;
}
function getAbsensi($rencana_id)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->where('absensi.rencana_perkuliahan_id', $rencana_id)
        ->get()->getRow();
    return $result;
}
function getPerubahanRencana($rencana_id)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->where('perubahan_rencana.rencana_perkuliahan_id', $rencana_id)
        ->where('perubahan_rencana.verifikasi', 1)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();
    return $result;
}
function getPerubahanRencanaTanggal($rencana_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->where('perubahan_rencana.rencana_perkuliahan_id', $rencana_id)
        ->where('perubahan_rencana.tanggal', $tanggal)
        ->where('perubahan_rencana.verifikasi', 1)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();
    return $result;
}
function getPerubahanRencanaTanggalFix($jadwal, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->where('rencana_perkuliahan.jadwal_kuliah_id', $jadwal)
        ->where('perubahan_rencana.tanggal', $tanggal)
        ->where('perubahan_rencana.verifikasi', 1)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();
    return $result;
}

function getDosen($tahunAkademikId, $matakuliahId, $jenisJadwal)
{
    $db = Database::connect();
    $builder = $db->table('jadwal_kuliah_dosen');
    $builder->select('dosen.nama');
    $builder->join('jadwal_kuliah', 'jadwal_kuliah_dosen.jadwal_kuliah_id = jadwal_kuliah.id');
    $builder->join('dosen', 'jadwal_kuliah_dosen.dosen_id = dosen.id');
    $builder->where('jadwal_kuliah.tahun_akademik_id', $tahunAkademikId);
    $builder->where('jadwal_kuliah.matakuliah_id', $matakuliahId);
    $builder->where('jadwal_kuliah.jenis_jadwal', $jenisJadwal);
    $builder->groupBy('dosen.id');

    $query = $builder->get();
    return $query->getResult();
}
function Kajur($jurusan)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('jabatan_kajur')
        ->select('jabatan_kajur.*, jurusan.nama_jurusan, dosen.nama, dosen.nip')
        ->join('jurusan', 'jabatan_kajur.jurusan_id = jurusan.id')
        ->join('dosen', 'jabatan_kajur.dosen_id = dosen.id')
        ->where('jurusan.id', $jurusan)
        ->where('jabatan_kajur.status', 1)
        ->get()->getRow();
    return $result;
}

function getPerubahanRencanaTanggalFixAndaJam($jadwal, $tanggal)
{
    $currentDateTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
    $currentDateTimeStr = $currentDateTime->format('H:i:s');

    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->where('rencana_perkuliahan.jadwal_kuliah_id', $jadwal)
        ->where('perubahan_rencana.tanggal', $tanggal)
        ->where('perubahan_rencana.verifikasi', 1)
        ->where('perubahan_rencana.jam_mulai <=', $currentDateTimeStr)
        ->where('perubahan_rencana.jam_selesai >=', $currentDateTimeStr)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();
    return $result;
}
function getPerubahanRencanaByJadwal($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('perubahan_rencana.tanggal', $tanggal)
        ->where('perubahan_rencana.verifikasi', 1)
        ->get()->getRow();
    return $result;
}
function getPerubahanRencanaByJadwalDosen($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Get the current date and time in Jakarta time zone
    $currentDateTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
    $currentDateTimeStr = $currentDateTime->format('H:i:s');

    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('perubahan_rencana.tanggal', $tanggal)
        ->where('perubahan_rencana.verifikasi', 1)
        ->where('perubahan_rencana.jam_mulai <=', $currentDateTimeStr)
        ->where('perubahan_rencana.jam_selesai >=', $currentDateTimeStr)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();

    return $result;
}
function getPerubahanRencanaByJadwalDosenPra($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Get the current date and time in Jakarta time zone
    $currentDateTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
    $currentDateTimeStr = $currentDateTime->format('H:i:s');

    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('rencana_perkuliahan.tanggal', $tanggal)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();

    return $result;
}
function getPerubahanRencanaByJadwalDosenNew($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Get the current date and time in Jakarta time zone
    $now = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
    $current_time = $now->format('H:i:s');

    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('perubahan_rencana.tanggal', $tanggal)
        ->where('perubahan_rencana.verifikasi', 1)
        // ->where('perubahan_rencana.jam_mulai', '<=', $current_time)
        // ->where('perubahan_rencana.jam_selesai', '>=', $current_time)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();

    return $result;
}
function getPerubahanRencanaByJadwalDosenJam($jadwal_id, $tanggal)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Get the current date and time in Jakarta time zone
    $now = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
    $current_time = $now->format('H:i:s');
    // dd($current_time);

    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*, rencana_perkuliahan.pertemuan')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal_id)
        ->where('perubahan_rencana.tanggal', $tanggal)
        ->where('perubahan_rencana.verifikasi', 1)
        ->where('perubahan_rencana.jam_mulai <=', $current_time)
        ->where('perubahan_rencana.jam_selesai >=', $current_time)
        ->orderBy('rencana_perkuliahan.pertemuan')
        ->get()->getRow();

    return $result;
}


function apaRencanaSudahDigunakan($rencana_id)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->where('absensi.rencana_perkuliahan_id', $rencana_id)
        ->countAllResults();
    return $result;
}
function apaMengajukanPerubahanRencana($rencana_id)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*')
        ->where('perubahan_rencana.rencana_perkuliahan_id', $rencana_id);
    return $result;
}

function perubahanByRencana($rencana_id)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('perubahan_rencana.*')
        ->where('perubahan_rencana.rencana_perkuliahan_id', $rencana_id)
        ->where('perubahan_rencana.verifikasi', 1)->get()->getRow();
    return $result;
}

function apakahDosenSudahAbsen($absen, $dosen)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('absensi_dosen.*')
        ->where('absensi_id', $absen)
        ->where('dosen_id', $dosen)
        ->countAllResults();
    return $result;
}
function GetAbsensiDosen($rencana_id)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('absensi_dosen.*, dosen.nama as nama_dosen')
        ->join('absensi', 'absensi_dosen.absensi_id = absensi.id')
        ->join('dosen', 'absensi_dosen.dosen_id =dosen.id')
        ->where('absensi.rencana_perkuliahan_id', $rencana_id)
        ->get()->getResult();
    return $result;
}
function GetAbsensiTeknisi($rencana_id)
{
    $db = Database::connect();
    $result = $db->table('absensi_teknisi')
        ->select('absensi_teknisi.*, teknisi.nama as nama_teknisi')
        ->join('absensi', 'absensi_teknisi.absensi_id = absensi.id')
        ->join('teknisi', 'absensi_teknisi.teknisi_id =teknisi.id')
        ->where('absensi.rencana_perkuliahan_id', $rencana_id)
        ->get()->getResult();
    return $result;
}
function apakahDosenSudahDiAbsen($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('absensi_dosen.*')
        ->where('absensi_id', $absen)
        ->countAllResults();
    return $result;
}
function apakahMahasiswaSudahDiAbsen($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->where('absensi_id', $absen)
        ->countAllResults();
    return $result;
}
function apakahMahasiswaSudahDiAbsenByRencana($rencana)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->select('absensi_mahasiswa.*')
        ->where('absensi.rencana_perkuliahan_id', $rencana)
        ->countAllResults();
    return $result;
}
function apakahDosenSudahAdaYangAbsen($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('absensi_dosen.*')
        ->where('absensi_id', $absen)
        ->countAllResults();
    return $result;
}
function apakahTeknisiSudahAbsen($absen, $teknisi)
{
    $db = Database::connect();
    $result = $db->table('absensi_teknisi')
        ->select('absensi_teknisi.*')
        ->where('absensi_id', $absen)
        ->where('teknisi_id', $teknisi)
        ->countAllResults();
    return $result;
}
function apakahSayaSudahAbsen($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id=absensi.id')
        ->where('absensi.rencana_perkuliahan_id', $absen)
        ->where('mahasiswa_id', session()->get('data')['id'])
        ->countAllResults();
    return $result;
}
function absenSudahMahasiswa($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*, absensi.type')
        ->join('absensi', 'absensi_mahasiswa.absensi_id=absensi.id')
        ->where('absensi.rencana_perkuliahan_id', $absen)
        ->where('mahasiswa_id', session()->get('data')['id'])
        ->get()->getRow();
    return $result;
}

// Pintasan didashbord
function adaPerubahanRencanaTidakHariIni($jadwal)
{
    $db = Database::connect();
    return $db->table('perubahan_rencana')->select('perubahan_rencana.*')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal)
        ->where('perubahan_rencana.tanggal', date('Y-m-d'))
        ->get()->getRow();
}
function adaRencanaTidakHariIni($jadwal)
{
    $db = Database::connect();
    return $db->table('rencana_perkuliahan')->select('rencana_perkuliahan.*')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where('jadwal_kuliah.id', $jadwal)
        ->where('rencana_perkuliahan.tanggal', date('Y-m-d'))
        ->get()->getRow();
}



function cekKehadiran($rencana, $mahasiswa)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id=absensi.id')
        // ->join('rencana_perkuliahan', 'absensi.absensi_id=rencana_perkuliahan.id')
        ->where('absensi.rencana_perkuliahan_id', $rencana)
        ->where('mahasiswa_id', $mahasiswa)
        ->get()->getRow();
    return $result;
}

// SPT MAHASISWA

function sptMahasiswa($mahasiswa_id, $ta)
{
    $db = Database::connect();
    $result = $db->table('spt')
        ->select('count(id) as jumlah')
        ->where('tahun_akademik_id', $ta)
        ->where('mahasiswa_id', $mahasiswa_id)
        ->get()->getRow();
    return $result;
}
function cekKehadiranSudahPP($absenmhs_id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('p_pengganti_detail.*')
        ->where('status', 1)
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $absenmhs_id)
        ->countAllResults();
    return $result;
}

function listDosenByJadwal($jadwal)
{
    $db = Database::connect();
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('dosen.nama as nama_dosen, dosen.id')
        ->join('jadwal_kuliah', 'jadwal_kuliah_dosen.jadwal_kuliah_id = jadwal_kuliah.id')
        ->join('dosen', 'jadwal_kuliah_dosen.dosen_id = dosen.id')
        ->where('jadwal_kuliah.id', $jadwal)
        ->get()->getResult();
    return $result;
}
function listTeknisiByJadwal($jadwal)
{
    $db = Database::connect();
    $result = $db->table('jadwal_kuliah_teknisi')
        ->select('teknisi.nama as nama_teknisi, teknisi.id')
        ->join('jadwal_kuliah', 'jadwal_kuliah_teknisi.jadwal_kuliah_id = jadwal_kuliah.id')
        ->join('teknisi', 'jadwal_kuliah_teknisi.teknisi_id = teknisi.id')
        ->where('jadwal_kuliah.id', $jadwal)
        ->get()->getResult();
    return $result;
}



// Praktik Pengganti

function siapaTeknisiYangAbsen($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_teknisi')
        ->select('teknisi.nama as nama_teknisi, teknisi.id')
        ->join('teknisi', 'absensi_teknisi.teknisi_id = teknisi.id')
        ->where('absensi_id', $absen);
    return $result->get()->getRow();
}
function siapaDosenYangAbsen($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('dosen.nama as nama_dosen, dosen.id')
        ->join('dosen', 'absensi_dosen.dosen_id = dosen.id')
        ->where('absensi_id', $absen);
    return $result;
}
function dosenPjByJadwal($jadwal_id)
{
    $db = Database::connect();
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('dosen.nama as nama_dosen, dosen.id')
        ->join('dosen', "jadwal_kuliah_dosen.dosen_id = dosen.id AND jadwal_kuliah_dosen.status = 'pj'")
        ->where('jadwal_kuliah_id', $jadwal_id);
    return $result;
}
function dosenPjByJadwalKaloTidakAdaPJ($jadwal_id)
{
    $db = Database::connect();
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('dosen.nama as nama_dosen, dosen.id')
        ->join('dosen', "jadwal_kuliah_dosen.dosen_id = dosen.id")
        ->where('jadwal_kuliah_id', $jadwal_id);
    return $result;
}

function sudahAjukanPP($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $id)->countAllResults();
    return $result;
}
function sudahDivalidasiPP($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $id)
        ->where('p_pengganti_master.validasi', 1)
        ->where('p_pengganti_master.lunas', 0)
        ->where('bukti_bayar', NULL)
        ->countAllResults();
    return $result;
}


function sudahMengajukanPPBelum($absenmhs_id, $matkul_id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('p_pengganti_detail.*, p_pengganti_master.lunas, p_pengganti_master.validasi, dosen.nama as nama_dosen')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->join('dosen', 'p_pengganti_detail.dosen_id = dosen.id')
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $absenmhs_id)
        ->where('p_pengganti_detail.matakuliah_id', $matkul_id)
        ->get()->getRow();
    return $result;
}
function mengajukanKeDosenSiapa($absensi_id, $dosen_id)
{
    $db = Database::connect();
    $result = $db->table('absensi_dosen')
        ->select('absensi_dosen.*')
        ->join('absensi', 'absensi_dosen.absensi_id = absensi.id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = absensi.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = rencana_perkuliahan.id')
        ->where('absensi.id', $absensi_id)
        ->where('p_pengganti_detail.matakuliah_id', $dosen_id)
        ->get()->getRow();
    return $result;
}




// RPS
function sudahUploadRps($where)
{
    $db = Database::connect();
    $result = $db->table('rps')
        ->select('*')
        ->where($where)
        ->countAllResults();
    return $result;
}

function dataRPS($where)
{
    $db = Database::connect();
    $result = $db->table('rps')
        ->select('*')
        ->where($where)
        ->get()->getRow();
    return $result;
}
function IsGenereteMateri($ta, $mk, $jenis)
{
    $db = Database::connect();
    $builder = $db->table('matakuliah_materi');
    $builder->select('*');

    $builder->where([
        'matakuliah_id' => $mk,
        'tahun_akademik_id' => $ta,
        'jenis' => $jenis,
    ]);

    return $builder->countAllResults();
}
function IsValidateMateri($ta, $mk, $jenis)
{
    $db = Database::connect();
    $builder = $db->table('matakuliah_materi');
    $builder->select('*');

    $builder->where([
        'matakuliah_id' => $mk,
        'tahun_akademik_id' => $ta,
        'jenis' => $jenis,
        'verifikasi' => 2,
    ]);

    return $builder->countAllResults();
}



function sudahDibayarPP($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $id)
        ->where('p_pengganti_master.validasi', 1)
        ->where('p_pengganti_master.lunas', 1)
        ->countAllResults();
    return $result;
}
function sudahValidasiDosen($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $id)
        ->where('p_pengganti_master.validasi', 1)
        ->where('p_pengganti_master.lunas', 1)
        ->where('p_pengganti_detail.status', 1)
        ->countAllResults();
    return $result;
}
function sudahUploadBayarPP($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $id)
        ->where('p_pengganti_master.validasi', 1)
        ->where('p_pengganti_master.lunas', 0)
        ->where('bukti_bayar !=', NULL)
        ->countAllResults();
    return $result;
}
// function sudahDibayarPP($id)
// {
//     $db = Database::connect();
//     $result = $db->table('p_pengganti_detail')
//         ->select('*')
//         ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
//         ->where('p_pengganti_detail.absensi_mahasiswa_id', $id)
//         ->where('p_pengganti_master.validasi', 1)
//         ->where('p_pengganti_master.lunas', 1)
//         ->countAllResults();
//     return $result;
// }
function sudahUploadPP($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_detail.absensi_mahasiswa_id', $id)
        ->where('p_pengganti_master.validasi', 1)
        ->where('p_pengganti_master.bukti_bayar !=', NULL)
        ->countAllResults();
    return $result;
}
function JumlahPPByTransaksi($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_master.id', $id)->countAllResults();
    return $result;
}
function JumlahPPByTransaksiValid($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('*')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_master.id', $id)
        ->where('p_pengganti_detail.status', 1)
        ->countAllResults();
    return $result;
}
function JumlahBayarByTransaksi($id)
{
    $db = Database::connect();
    $result = $db->table('p_pengganti_detail')
        ->select('sum(p_pengganti_detail.biaya) as total')
        ->join('p_pengganti_master', 'p_pengganti_detail.pp_master_id = p_pengganti_master.id')
        ->where('p_pengganti_master.id', $id)
        ->groupBy('p_pengganti_master.id')->get()->getRow();
    return $result;
}
function isClasOpened($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('*')
        ->where('rencana_perkuliahan_id', $absen)
        ->countAllResults();
    return $result;
}
function apakahSayaSudahMengabsenAbsen($absen)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->where('absensi_id', $absen)
        // ->where('mahasiswa_id', session()->get('data')['id'])
        ->countAllResults();
    return $result;
}
function apakahMahasiswaSudahAbsen($absen, $mahasiswa)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->where('absensi_id', $absen)
        ->where('mahasiswa_id', $mahasiswa)
        ->countAllResults();
    return $result;
}
function absenMahasiswa($absen, $mahasiswa)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->where('absensi_id', $absen)
        ->where('mahasiswa_id', $mahasiswa)
        ->get()->getRow();
    return $result;
}
function sm($absen, $mahasiswa)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->where('absensi_id', $absen)
        ->where('mahasiswa_id', $mahasiswa)
        ->get()->getRow();
    return $result;
}

function apakahSayaPunyaJabatan($kelas, $mhsid)
{
    $db = Database::connect();
    $result = $db->table('kelas_detail')
        ->select('kelas_detail.*, mahasiswa.npm, mahasiswa.nama')
        ->join('kelas_master', 'kelas_detail.kelas_master_id = kelas_master.id')
        ->join('mahasiswa', 'kelas_detail.mahasiswa_id = mahasiswa.id')
        ->where('kelas_detail.kelas_master_id', $kelas)
        ->where('kelas_detail.mahasiswa_id', $mhsid)
        ->where('kelas_detail.jabatan !=', 'anggota')
        ->orderBy('mahasiswa.npm')
        ->countAllResults();
    return $result;
}

function getMahasiswaKelas($kelas_master)
{
    $db = Database::connect();
    $result = $db->table('kelas_detail')
        ->select('kelas_detail.*, mahasiswa.npm, mahasiswa.nama')
        ->join('kelas_master', 'kelas_detail.kelas_master_id = kelas_master.id')
        ->join('mahasiswa', 'kelas_detail.mahasiswa_id = mahasiswa.id')
        ->where('kelas_detail.kelas_master_id', $kelas_master)
        ->orderBy('mahasiswa.npm')
        ->get()->getResult();
    return $result;
}
function getDosenPengampu($jadwal_id)
{
    $db = Database::connect();
    $result = $db->table('jadwal_kuliah_dosen')
        ->select('jadwal_kuliah_dosen.*, dosen.nip, dosen.nama')
        ->join('jadwal_kuliah', 'jadwal_kuliah_dosen.jadwal_kuliah_id = jadwal_kuliah.id')
        ->join('dosen', 'jadwal_kuliah_dosen.dosen_id = dosen.id')
        ->where('jadwal_kuliah_dosen.jadwal_kuliah_id', $jadwal_id)
        ->get()->getResult();
    return $result;
}


function getTeknisiPengampu($jadwal_id)
{
    $db = Database::connect();
    $result = $db->table('jadwal_kuliah_teknisi')
        ->select('jadwal_kuliah_teknisi.*, teknisi.nip, teknisi.nama')
        ->join('jadwal_kuliah', 'jadwal_kuliah_teknisi.jadwal_kuliah_id = jadwal_kuliah.id')
        ->join('teknisi', 'jadwal_kuliah_teknisi.teknisi_id = teknisi.id')
        ->where('jadwal_kuliah_teknisi.jadwal_kuliah_id', $jadwal_id)
        ->get()->getResult();
    return $result;
}
function getTeknisiByJadwal($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_kuliah_teknisi')
        ->select('teknisi.nip, teknisi.nama as nama_teknisi, jadwal_kuliah_teknisi.id')
        ->join('teknisi', 'jadwal_kuliah_teknisi.teknisi_id = teknisi.id')
        ->where('jadwal_kuliah_id', $jadwalId)

        ->get()->getResultArray();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getTeknisiByJadwalUas($jadwalId)
{
    // Ambil koneksi database
    $db = Database::connect();

    // Pengecekan keberadaan data di tabel kelas_detail
    $result = $db->table('jadwal_uas_teknisi')
        ->select('teknisi.nip, teknisi.nama as nama_teknisi, jadwal_uas_teknisi.id')
        ->join('teknisi', 'jadwal_uas_teknisi.teknisi_id = teknisi.id')
        ->where('jadwal_uas_id', $jadwalId)

        ->get()->getResultArray();
    // Hasilnya true jika data ditemukan, false jika tidak
    return $result;
}
function getSoalByJadwal($where)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('soal_detail')
        ->select('soal_detail.*')
        ->join('soal_master', 'soal_detail.soal_master_id = soal_master.id')
        ->where($where)
        ->get()->getResult();
    return $result;
}
function countAbsensi($where)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('absensi')
        ->select('absensi.*')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where($where)
        ->countAllResults();
    return $result;
}



// Absensi Apel Pada Dosen
function sudahAbsenApelSenin($where)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('apel')
        ->select('apel.*')
        ->where('apel_rencana_id', $where)
        ->get()->getRow();
    return $result;
}
function MahasiswaSudahAbsenApelSenin($where)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('apel_pelaksanaan')
        ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->select('apel.*')
        ->where('apel_rencana_id', $where)
        ->get()->getRow();
    return $result;
}

// Mahasiswa sudah absen belum?
function MahasiswaSudahAbsenApel($where)
{
    // Ambil koneksi database
    $db = Database::connect();
    $result = $db->table('apel_pelaksanaan')
        ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->select('apel_pelaksanaan.*')
        ->where($where)
        ->get()->getRow();
    return $result;
}



function getApelToday($id)
{
    $db = Database::connect();
    date_default_timezone_set('Asia/Jakarta');
    $result = $db->table('apel')
        ->select('apel.*, apel_rencana.minggu, apel_rencana.tanggal, apel_rencana.nama_apel')
        // ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->join('apel_rencana', 'apel.apel_rencana_id = apel_rencana.id')
        ->where([
            'apel_rencana.id' => $id,
            'apel_rencana.tanggal' => date('Y-m-d')
        ])
        ->get()->getRow();

    return $result;
}

function sudahAbsenApelBelum($apel_id)
{
    $db = Database::connect();
    $result = $db->table('apel_pelaksanaan')->select('apel.*, apel_rencana.minggu, apel_rencana.tanggal, apel_rencana.nama_apel, apel_pelaksanaan.status, apel_pelaksanaan.kehadiran, apel_pelaksanaan.berseragam')
        ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->join('apel_rencana', 'apel.apel_rencana_id = apel_rencana.id')
        ->where([
            'apel_pelaksanaan.mahasiswa_id' => session()->get('data')['id'],
            'apel.id' => $apel_id
        ])
        ->get()->getRow();

    return $result;
}

// APEL SENIN MAHSISWA

function kehadiranApel($where, $or = null)
{
    $db = Database::connect();
    $result = $db->table('apel_pelaksanaan')
        ->select('apel_pelaksanaan.*')
        ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->join('apel_rencana', 'apel.apel_rencana_id = apel_rencana.id')
        ->where($where);

    if ($or != null) {
        $result->whereIn('apel_pelaksanaan.kehadiran', ['H', 'T']);
    }
    // $result->groupBy('apel_pelaksanaan.id');
    // dd($result->getLastQuery());

    return $result->countAllResults();
    // dd($db->lastQuery());
}


function jumlahMahasiswaOnClass($kelas)
{
    $db = Database::connect();
    $result = $db->table('kelas_detail')
        ->select('kelas_detail.*')
        ->where('kelas_master_id', $kelas)
        ->countAllResults();
    return $result;
}

function jumlahMahasiswaHaveAbsen($kelas, $apelRencanaId)
{
    $db = Database::connect();
    $result = $db->table('kelas_detail')
        ->select('COUNT(kelas_detail.id) as jumlah_mahasiswa')
        ->join('mahasiswa', 'mahasiswa.id = kelas_detail.mahasiswa_id')
        ->join('apel_pelaksanaan', 'apel_pelaksanaan.mahasiswa_id = kelas_detail.mahasiswa_id')
        ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->where('kelas_detail.kelas_master_id', $kelas)
        ->where('apel_pelaksanaan.status', 1)
        ->where('apel.apel_rencana_id', $apelRencanaId)
        ->countAllResults();
    return $result;
}







// KOMPENSASI

function getJamKompenAbsen($mahasiswa_id)
{
    $db = Database::connect();
    $result = $db->table('absensi_mahasiswa')->select('sum(kompensasi) as jumlah_kompensasi')
        ->where('mahasiswa_id', $mahasiswa_id)
        ->groupBy('mahasiswa_id')
        ->get()->getRow();
    return $result;
}
// public function getJamKompen($mahasiswa_id)
// {
//     $result = $this->db->table('absensi_mahasiswa')->select('sum(kompensasi) as jumlah_kompensasi')
//         ->where('mahasiswa_id', $mahasiswa_id)
//         ->groupBy('mahasiswa_id')
//         ->get()->getRow();
//     return $result;
// }

function getJamKompenApel($mahasiswa_id)
{
    $db = Database::connect();
    return $db->table('apel_pelaksanaan')
        ->select('sum(kompensasi) as jumlah_kompensasi')
        ->join('apel', 'apel_pelaksanaan.apel_id = apel.id')
        ->join('apel_rencana', 'apel.apel_rencana_id = apel_rencana.id')
        ->where('apel_pelaksanaan.mahasiswa_id', $mahasiswa_id)
        ->groupBy('mahasiswa_id')
        ->get()->getRow();
}
function getPelaksanaanKompen($mahasiswa_id)
{
    $db = Database::connect();
    return $db->table('kompensasi_pelaksanaan')
        ->select('sum(jam) as jumlah_pelaksanaan')
        ->where('mahasiswa_id', $mahasiswa_id)
        ->where('status', 1)
        ->groupBy('mahasiswa_id')
        ->get()->getRow();
}


// JUMLAH MATAKULIAH PADA JADWAL

function getMatakuliahByKelas($kelas)
{
    $db = Database::connect();
    return $db->table('jadwal_kuliah')
        ->select('matakuliah.nama_mk, matakuliah.kode_mk, matakuliah.id')
        ->join('matakuliah', 'jadwal_kuliah.matakuliah_id = matakuliah.id')
        ->join('kelas_master', 'jadwal_kuliah.kelas_master_id = kelas_master.id')
        ->where('kelas_master_id', $kelas)
        // ->where("matakuliah.id NOT IN (SELECT matakuliah_id FROM jadwal_uas WHERE kelas_master_id = '$kelas')")
        ->groupBy('matakuliah_id')->countAllResults();
}

function getJadwalByRuanganAndDay($hari, $ruangan, $ta)
{
    $db = Database::connect();
    return $db->table('jadwal_kuliah')
        ->select('matakuliah.nama_mk, matakuliah.kode_mk, matakuliah.id, prodi.nama_prodi, kelas_master.kode_kelas, jadwal_kuliah.jam_mulai, jadwal_kuliah.jam_selesai, jadwal_kuliah.semester, kode_jurusan')
        ->join('matakuliah', 'jadwal_kuliah.matakuliah_id = matakuliah.id')
        ->join('prodi', 'jadwal_kuliah.prodi_id = prodi.id')
        ->join('jurusan', 'jadwal_kuliah.jurusan_id = jurusan.id')
        ->join('kelas_master', 'jadwal_kuliah.kelas_master_id = kelas_master.id')
        ->where('jadwal_kuliah.hari', $hari)
        ->where('jadwal_kuliah.gedung_id', $ruangan)
        ->where('jadwal_kuliah.tahun_akademik_id', $ta)
        // ->where("matakuliah.id NOT IN (SELECT matakuliah_id FROM jadwal_uas WHERE kelas_master_id = '$kelas')")
        ->get()->getResult();
}

// JUMLAH MATAUKULIAH PADA JADWAL UAS YANG SUDAH DIINPUT
function getJadwalUasByKelas($kelas)
{
    $db = Database::connect();
    return $db->table('jadwal_uas')
        ->select('matakuliah.nama_mk, matakuliah.kode_mk,  gedung.nama as nama_gedung, jadwal_uas.*')
        ->join('matakuliah', 'jadwal_uas.matakuliah_id = matakuliah.id')
        ->join('gedung', 'jadwal_uas.gedung_id = gedung.id')
        ->join('kelas_master', 'jadwal_uas.kelas_master_id = kelas_master.id')
        ->where('kelas_master_id', $kelas)->countAllResults();
}

// JUMLAH TEORI PRAKTIK PADA TIAP MATAKULIAH
function getJumlahTeoriPraktikMatkul($matakuliah_id)
{
    $db = Database::connect();
    return $db->table('matakuliah')
        ->select('matakuliah.*')
        ->where('id', $matakuliah_id)->get()->getRow();
}
// JUMLAH TEORI PRAKTIK PADA TIAP MATAKULIAH
function cekSeberapaLayak($where)
{
    $db = Database::connect();
    return $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where($where)->countAllResults();
}
function cekSeberapaLayakAlfa($where)
{
    $db = Database::connect();

    return $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where($where)
        ->groupStart() // Mulai grup untuk kondisi AND
        ->where('absensi_mahasiswa.kehadiran !=', 'H')
        ->whereNotIn('absensi_mahasiswa.id', function ($builder) {
            return $builder->select('p_pengganti_detail.absensi_mahasiswa_id')
                ->from('p_pengganti_detail')
                ->join('p_pengganti_master', 'p_pengganti_master.id = p_pengganti_detail.pp_master_id')
                ->where('p_pengganti_detail.status', 1)
                ->where('p_pengganti_master.lunas', 1)
                ->where('p_pengganti_master.validasi', 1);
        })
        ->groupEnd() // Akhiri grup untuk kondisi AND
        ->countAllResults();
}

function getVer($mahasiswa_id, $ta = null)
{
    $db = \Config\Database::connect();

    $query = $db->table('kelas_detail')
        ->select('kelas_detail.*, kelas_master.*, tahun_akademik.*')
        ->join('kelas_master', 'kelas_detail.kelas_master_id = kelas_master.id')
        ->join('tahun_akademik', 'kelas_master.tahun_akademik_id = tahun_akademik.id')
        ->where('kelas_detail.mahasiswa_id', $mahasiswa_id);

    // Jika parameter $ta diberikan, gunakan sebagai filter tahun akademik, jika tidak, pilih yang aktif
    if ($ta) {
        $query->where('kelas_master.tahun_akademik_id', $ta);
    } else {
        $query->where('tahun_akademik.status', 1);
    }

    return $query->get()->getRow();
}


function cekSeberapaLayakAlfaTeori($where)
{
    $db = Database::connect();

    return $db->table('absensi_mahasiswa')
        ->select('absensi_mahasiswa.*')
        ->join('absensi', 'absensi_mahasiswa.absensi_id = absensi.id')
        ->join('rencana_perkuliahan', 'absensi.rencana_perkuliahan_id = rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id = jadwal_kuliah.id')
        ->where($where)
        ->where('absensi_mahasiswa.kehadiran !=', 'H')
        ->countAllResults();
}
function jadwalUASMahasiswa($where)
{
    $db = Database::connect();

    return $db->table('jadwal_uas')
        ->select('jadwal_uas.*, gedung.nama as nama_gedung')
        ->join('gedung', 'jadwal_uas.gedung_id = gedung.id')

        ->where($where)
        ->get()->getRow();
}
function getPengajuanPerubahan($prodi_id)
{
    $db = Database::connect();
    $result = $db->table('perubahan_rencana')
        ->select('rencana_perkuliahan.id,matakuliah.nama_mk, dosen.nama as nama_dosen, rencana_perkuliahan.jam_mulai as jam_mulai_rencana, rencana_perkuliahan.jam_selesai as jam_selesai_rencana,
        rencana_perkuliahan.tanggal as tanggal_rencana, rencana_perkuliahan.topik as topik_rencana, rencana_perkuliahan.id as id_rencana, perubahan_rencana.*')
        ->join('rencana_perkuliahan', 'perubahan_rencana.rencana_perkuliahan_id=rencana_perkuliahan.id')
        ->join('jadwal_kuliah', 'rencana_perkuliahan.jadwal_kuliah_id=jadwal_kuliah.id')
        ->join('dosen', 'perubahan_rencana.dosen_id = dosen.id')
        ->join('matakuliah', 'jadwal_kuliah.matakuliah_id = matakuliah.id')
        ->join('tahun_akademik', 'jadwal_kuliah.tahun_akademik_id = tahun_akademik.id')
        ->where('jadwal_kuliah.prodi_id', $prodi_id)
        ->where('tahun_akademik.status', 1)
        ->where('perubahan_rencana.verifikasi', 0);


    return $result->orderBy('verifikasi', 'ASC')
        ->countAllResults();
}


function kurikulumByKelas($kelas_master_id)
{
    $db = \Config\Database::connect();

    $builder = $db->table('kurikulum')
        ->select('kurikulum.*')
        ->join('mahasiswa', 'mahasiswa.kurikulum_id = kurikulum.id')
        ->join('kelas_detail', 'kelas_detail.mahasiswa_id = mahasiswa.id')
        ->join('kelas_master', 'kelas_master.id = kelas_detail.kelas_master_id')
        ->where('kelas_master.id', $kelas_master_id)
        ->groupBy('kurikulum.id');

    return $builder->get()->getResult();
}

function kurikulumByKelasOne($kelas_master_id)
{
    $db = \Config\Database::connect();

    $builder = $db->table('kurikulum')
        ->select('kurikulum.*')
        ->join('mahasiswa', 'mahasiswa.kurikulum_id = kurikulum.id')
        ->join('kelas_detail', 'kelas_detail.mahasiswa_id = mahasiswa.id')
        ->join('kelas_master', 'kelas_master.id = kelas_detail.kelas_master_id')
        ->where('kelas_master.id', $kelas_master_id)
        ->groupBy('kurikulum.id');

    return $builder->get()->getRow();
}
function kurikulumByMahasiswa($mahasiswa_id)
{
    $db = \Config\Database::connect();

    $builder = $db->table('kurikulum')
        ->select('kurikulum.*')
        ->join('mahasiswa', 'mahasiswa.kurikulum_id = kurikulum.id')
        ->where('mahasiswa.id', $mahasiswa_id);
    return $builder->get()->getRow();
}


function konversiMenitKeJam($totalMenit)
{
    // Menghitung jumlah jam
    $jam = floor($totalMenit / 60);

    return $jam;
}



// hitung telat
function hitungSelisihWaktuMenit($waktuAwal, $waktuAkhir)
{
    // Konversi string waktu menjadi menit
    list($jamAwal, $menitAwal, $detikAwal) = explode(":", $waktuAwal);
    list($jamAkhir, $menitAkhir, $detikAkhir) = explode(":", $waktuAkhir);

    // Hitung selisih waktu dalam menit
    $selisihWaktuMenit = ($jamAkhir * 60 + $menitAkhir) - ($jamAwal * 60 + $menitAwal);

    return $selisihWaktuMenit;
}


// Fungsi-fungsi lainnya...

if (!function_exists('encrypt_url')) {
    function encrypt_url($data)
    {
        return urlencode(base64_encode($data));
    }
}

if (!function_exists('decrypt_url')) {
    function decrypt_url($encryptedData)
    {
        return base64_decode(urldecode($encryptedData));
    }
}

if (!function_exists('cek_login')) {
    function cek_login($role = null)
    {
        $session = session();
        if (!$session->has('username')) {
            return redirect()->to('/');
        }
    }
}


function menitToJamMenit($menit)
{
    if ($menit < 0) {
        return false; // Menangani input negatif, sesuai dengan kebutuhan
    }

    $jam = floor($menit / 60);
    $menitSisa = $menit % 60;

    // Format hasil ke dalam string
    $hasil = ($jam > 0 ? ($jam < 10 ? '0' : '') . $jam . ' Jam ' : '') .
        ($menitSisa > 0 ? ($menitSisa < 10 ? '0' : '') . $menitSisa . ' Menit' : ($jam == 0 ? '0 Menit' : ''));

    return $hasil;
}


function tglIndo($tanggal)
{
    // Konversi tanggal ke objek DateTime
    $dateTime = new DateTime($tanggal);

    // Array nama hari dalam bahasa Indonesia
    $hari = [
        'Minggu', 'Senin', 'Selasa',
        'Rabu', 'Kamis', 'Jumat', 'Sabtu'
    ];

    // Ambil nama hari dari array
    $namaHari = $hari[$dateTime->format('w')];

    // Ambil komponen tanggal
    $day = $dateTime->format('d');
    $month = $dateTime->format('m');
    $year = $dateTime->format('Y');

    // Array nama bulan dalam bahasa Indonesia
    $bulan = [
        'Januari', 'Februari', 'Maret',
        'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember'
    ];

    // Ambil nama bulan dari array
    $namaBulan = $bulan[(int)$month - 1];

    // Format tanggal dalam format Indonesia
    $tanggalIndonesia = $namaHari . ', ' . $day . ' ' . $namaBulan . ' ' . $year;

    return $tanggalIndonesia;
}
function hariIndo($tanggal)
{
    // Set timezone ke Asia/Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Konversi tanggal ke timestamp
    $timestamp = strtotime($tanggal);

    // Array nama hari dalam bahasa Indonesia
    $hari = [
        'Minggu', 'Senin', 'Selasa',
        'Rabu', 'Kamis', 'Jumat',
        'Sabtu'
    ];

    // Ambil nama hari berdasarkan indeks dari timestamp
    return $hari[date('w', $timestamp)];
}

function tglIndoSimple($tanggal)
{
    // Set timezone ke Asia/Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Konversi tanggal ke timestamp
    $timestamp = strtotime($tanggal);

    // Ambil komponen tanggal
    $day = date('d', $timestamp);

    // Array nama bulan dalam bahasa Indonesia
    $bulan = [
        'Jan', 'Feb', 'Mar',
        'Apr', 'Mei', 'Jun',
        'Jul', 'Ags', 'Sep',
        'Okt', 'Nov', 'Des'
    ];

    // Ambil nama bulan dari array
    $namaBulan = $bulan[(int)date('m', $timestamp) - 1];

    // Ambil tahun
    $year = date('Y', $timestamp);

    // Format tanggal dalam format yang diinginkan (01 Jan 2024)
    $tanggalFormatted = $day . ' ' . $namaBulan . ' ' . $year;

    return $tanggalFormatted;
}

function hitungRentangMenit($waktuMulai, $waktuSelesai)
{
    // Pisahkan jam dan menit dari waktu mulai
    list($jamMulai, $menitMulai) = explode(':', $waktuMulai);
    // Pisahkan jam dan menit dari waktu selesai
    list($jamSelesai, $menitSelesai) = explode(':', $waktuSelesai);

    // Konversi string jam dan menit menjadi integer
    $jamMulai = (int) $jamMulai;
    $menitMulai = (int) $menitMulai;
    $jamSelesai = (int) $jamSelesai;
    $menitSelesai = (int) $menitSelesai;

    // Konversi waktu mulai dan selesai ke total menit
    $totalMenitMulai = ($jamMulai * 60) + $menitMulai;
    $totalMenitSelesai = ($jamSelesai * 60) + $menitSelesai;

    // Hitung selisih total menit
    $selisihMenit = $totalMenitSelesai - $totalMenitMulai;

    // Kembalikan hasil selisih
    return $selisihMenit;
}


function tglIndoWithTime($datetime)
{
    // Konversi DateTime ke string format
    $formattedDateTime = $datetime->format('Y-m-d H:i:s');

    // Ubah string format menjadi timestamp
    $timestamp = strtotime($formattedDateTime);

    // Panggil fungsi tglIndo untuk konversi tanggal
    $tanggalIndo = tglIndoTime($timestamp);

    return $tanggalIndo;
}
function tglIndoTime($datetime)
{
    // Konversi string datetime ke timestamp
    $timestamp = strtotime($datetime);

    // Konversi timestamp ke objek DateTime
    $dateTime = new DateTime('@' . $timestamp);

    // Array nama hari dalam bahasa Indonesia
    $hari = [
        'Minggu', 'Senin', 'Selasa',
        'Rabu', 'Kamis', 'Jumat', 'Sabtu'
    ];

    // Ambil nama hari dari array
    $namaHari = $hari[$dateTime->format('w')];

    // Ambil komponen tanggal
    $day = $dateTime->format('d');
    $month = $dateTime->format('m');
    $year = $dateTime->format('Y');
    $hour = $dateTime->format('H');
    $minute = $dateTime->format('i');
    $second = $dateTime->format('s');

    // Array nama bulan dalam bahasa Indonesia
    $bulan = [
        'Januari', 'Februari', 'Maret',
        'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember'
    ];

    // Ambil nama bulan dari array
    $namaBulan = $bulan[(int)$month - 1];

    // Format tanggal dalam format Indonesia
    $tanggalIndonesia = $namaHari . ', ' . $day . ' ' . $namaBulan . ' ' . $year . ' | Pukul ' . $hour . ':' . $minute . ':' . $second;

    return $tanggalIndonesia;
}



function statusAbsen($kehadiran)
{
    switch ($kehadiran) {
        case 'H':
            return 'Hadir';
            break;
        case 'A':
            return 'Alfa';
            break;
        case 'I':
            return 'Izin';
            break;
        case 'S':
            return 'Sakit';
            break;

        default:
            break;
    }
}


function jam($tanggal)
{
    $timestamp = strtotime($tanggal);
    return date("H:i", $timestamp);
}

function konversiRupiah($angka)
{
    try {
        // Pastikan angka yang diberikan adalah numerik
        $angka = floatval($angka);

        // Format angka menjadi mata uang Rupiah dengan pemisah ribuan
        $rupiahFormat = number_format($angka, 0, ',', '.');

        // Tambahkan simbol mata uang Rupiah
        $rupiahFormat = "Rp " . $rupiahFormat;

        return $rupiahFormat;
    } catch (Exception $e) {
        return "Input tidak valid. Masukkan angka.";
    }
}



if (!function_exists('lengkapiProfile')) {
    function lengkapiProfile($npm)
    {


        $db = Database::connect();
        $profil = $db->table('mahasiswa')
            ->select('*')

            ->where([
                'npm' => $npm,
            ])
            ->get()->getRow();

        // Tentukan kolom-kolom yang ingin Anda hitung persentasenya
        $kolomYangDihitung = array(
            'npm', 'nama', 'email', 'jenis_kelamin', 'no_hp', 'tanggal_lahir', 'tempat_lahir', 'alamat',
            'prodi_id', 'jurusan_id', 'asal_sekolah', 'tahun_lulus_sekolah', 'jenis_sekolah', 'jurusan_sma',
            'nama_ayah', 'pekerjaan_ayah_id', 'penghasilan_ayah_id', 'no_hp_ayah', 'nama_ibu',
            'pekerjaan_ibu_id', 'penghasilan_ibu_id', 'no_hp_ibu', 'tahun_masuk', 'jalur_masuk_id',
            'pembiayaan_id', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'status',
            'tahun_akademik_id', 'foto',
            // ... tambahkan kolom-kolom lain yang ingin Anda hitung
        );

        $jumlahKolomTerisi = 0;

        foreach ($kolomYangDihitung as $kolom) {
            // Ganti notasi array menjadi notasi objek
            if (!empty($profil->{$kolom})) {
                $jumlahKolomTerisi++;
            }
        }

        // Hitung persentase
        $totalKolom = count($kolomYangDihitung);
        $persentaseTerisi = ($jumlahKolomTerisi / $totalKolom) * 100;

        return $persentaseTerisi;
    }


    function contentLaporan($uri)
    {
        switch ($uri) {
            case 'rekap-jadwal':
                return 'Rekap Jadwal Perkuliahan';
                break;
            case 'rekap-rps':
                return 'Rekap RPS';
                break;
            case 'rekap-perkuliahan':
                return 'Rekap Perkuliahan';
                break;
            case 'rekap-soal':
                return 'Rekap Soal';
                break;
            case 'terlambat':
                return 'Rekap Data Keterlambatan';
                break;
            case 'rekap-layak':
                return 'Rekap Kelayakan UAS';
                break;
            case 'pp':
                return 'Praktik Pengganti';
                break;
            case 'disiplin':
                return 'Rekap Data Kedisiplinan';
                break;
            case 'kompensasi':
                return 'Rekap Data Kompensasi';
                break;
            case 'tak-terlaksana':
                return 'Rekap Data Ketidakterlaksanaan';
                break;

            default:
                return 'Tidak ada';
                break;
        }
    }
    function contentPP($uri)
    {
        switch ($uri) {
            case 'rekap':
                return 'Rekap Praktik Pengganti';
                break;
            case 'verifikasi':
                return 'Verifikasi Praktik Pengganti';
                break;
            case 'pembayaran':
                return 'Pembayaran Praktik Pengganti';
                break;


            default:
                return 'Tidak ada';
                break;
        }
    }
}

function kehadiran($kehadiran)
{
    switch ($kehadiran) {
        case 'I':
            return '<span class="text text-warning">Izin</span>';
            break;
        case 'H':
            return '<span class="text text-primary">Hadir</span>';
            break;
        case 'A':
            return '<span class="text text-danger">Alfa</span>';
            break;
        case 'S':
            return '<span class="text text-info">Sakit</span>';
            break;
        default:
            return 'Tidak ada';
            break;
    }
}
