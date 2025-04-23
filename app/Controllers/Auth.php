<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\Admin\UsersModel;
use Ramsey\Uuid\Uuid;

class Auth extends BaseController
{

    protected $Auth;
    protected $userModel;
    protected $db;
    protected $session;

    public function __construct()
    {
        // Inisialisasi model tahun akademik
        $this->Auth = new AuthModel();
        $this->userModel = new UsersModel();
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function index()
    {

        // var_dump(session()->get('logged_in'));die;
        if (session()->get('logged_in')) {
            // Jika ada session 'logged_id', redirect ke dashboard berdasarkan peran (role)
            return redirect()->to(strtolower(session()->get('role')) . '/dashboard');
        } else {
            // Jika tidak ada session 'logged_id', tampilkan halaman login
            $data = [
                "title" => "Halaman Login - Aplikasi Ari Andika",
                'errors' => session('errors'), // Tambahkan validation ke data
            ];
            return view('auth/indexx', $data);
        }
    }


    public function checkAuth()
    {
        // dd($this->request->getPost());
        $validation = $this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Username atau Email tidak boleh kosong'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Password tidak boleh kosong'
                ]
            ],

        ]);
        // dd($validation);

        if (!$validation) {
            $errors = \Config\Services::validation()->getErrors();

            return redirect()->back()->withInput()->with('errors', $errors);
        }



        $user = $this->Auth->checkUser($this->request->getPost('username'), $this->request->getPost('password'));

        //  $this->session->destroy();

        $session = session();
        // dd($user);
        if ($user) {

            if (hash('sha256', sha1('poltekla')) == $user['password'] || hash('sha256', sha1('123456')) == $user['password']) {
                session()->set('user_id', $user['id']);
                session()->set('user_name', $user['username']);
                return redirect()->to('/auth/update-password');
            }
            // session()->setFlashdata('primary', 'Hello.... Selamat Datang');

            switch ($user['role']) {
                case 'Admin':
                    $session->set('data', $user);
                    $session->set('role', $user['role']);
                    $session->set([
                        'logged_in' => TRUE
                    ]);
                    return redirect()->to('/admin/dashboard');
                    break;
                case 'Karyawan':
                    $session->set('data', $user);
                    $session->set('role', $user['role']);
                    $session->set([
                        'logged_in' => TRUE
                    ]);
                    return redirect()->to('/karyawan/dashboard');
                    break;

                default:
                    return redirect()->to('/');
            }
            // tambahkan ini
            return redirect()->to('/');
        } else {
            // Kasus jika username tidak ditemukan atau password salah
            session()->setFlashdata('error', 'Username atau Password salah.'); // tambahkan ini
            return redirect()->to('/');
        }
    }



    public function logOut()
    {


        $this->session->destroy();
        return redirect()->to('/auth');
    }
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $userModel = new UsersModel();

            // Validasi input
            $rules = [
                'username' => 'required|is_unique[users.username]',
                'password' => 'required|min_length[6]',
                'nama' => 'required',
            ];

            if (!$this->validate($rules)) {
                return view('auth/register', ['validation' => $this->validator]);
            }

            // Simpan data ke database
            $userModel->save([
                'username' => $this->request->getPost('username'),
                'password' => hash('sha256', sha1($this->request->getPost('password'))), // Hash yang sama
                'nama' => $this->request->getPost('nama'),
                'role_id' => 2, // Set default role_id = 2
            ]);            

            return redirect()->to('/')->with('success', 'Account created successfully. Please log in.');
        }

        return view('auth/register');
    }
}
