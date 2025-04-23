<?php

// namespace App\Helpers;


// use CodeIgniter\Database\ConnectionInterface;

// class CoreHelper
// {
//     protected $db;

//     public function __construct(ConnectionInterface &$db)
//     {
//         $this->db = &$db;
//     }

//     public function isMahasiswaInKelasDetail($kelasMasterId, $mahasiswaId)
//     {
//         // Periksa keberadaan data di tabel kelas_detail
//         $query = $this->db->table('kelas_detail')
//             ->where('kelas_master_id', $kelasMasterId)
//             ->where('mahasiswa_id', $mahasiswaId)
//             ->get();

//         return $query->getRow() !== null;
//     }

//     // Fungsi lainnya...
// }
