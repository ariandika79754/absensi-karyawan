<?php

namespace App\Controllers;

use App\Models\Admin\KategoriModel;
use App\Models\Admin\ProductModel;
use App\Models\Admin\UsersModel;
use App\Models\Admin\TransaksiModel;

class AdminDashboard extends BaseController
{
    public function index(): string
    {
        return view('konten/admin/dashboard/index.php');
    }

}
