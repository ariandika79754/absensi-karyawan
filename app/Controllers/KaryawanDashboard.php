<?php
namespace App\Controllers;

class KaryawanDashboard extends BaseController
{
    public function index(): string
    {
        return view('konten/karyawan/dashboard/index.php');
    }

}

