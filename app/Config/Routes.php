<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('back', function () {
    return redirect()->back();
});


$routes->get('server', 'Server::getServerTime');

$routes->get('/', 'Auth::index');
// $routes->get('/', 'Auth::index'); // Ini akan mencocokkan "/auth/"
$routes->group('auth', ['filter' => 'redirectIfAuthenticated'], function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('logout', 'Auth::logout', ['filter' => null]); // Mengecualikan dari filter
    $routes->post('check-auth', 'Auth::checkAuth');
});

// Admin
$routes->group('admin', ['filter' => 'authenticate'], function ($routes) {
    // $routes->group("Admin", ["filter" => "auth"], function ($routes) {
    $routes->get('dashboard', 'AdminDashboard::index', ['filter' => 'authenticate']);
    $routes->get('logout', 'Auth::logout', ['filter' => null]);

    // Admin Profile
    $routes->get('profile', 'AdminProfil::index');
    $routes->post('users/update', 'AdminProfil::updatePelanggan');

    // Admin Karyawan
    $routes->get('karyawan', 'AdminKaryawan::index');
    $routes->get('karyawan/add', 'AdminKaryawan::add');
    $routes->post('karyawan/save', 'AdminKaryawan::save');
    $routes->get('karyawan/edit/(:any)', 'AdminKaryawan::edit/$1');
    $routes->post('karyawan/update/(:any)', 'AdminKaryawan::update/$1');
    $routes->get('karyawan/delete/(:any)', 'AdminKaryawan::deleteKaryawan/$1');

    // Admin Users
    $routes->get('master/users', 'AdminUsers::index');
    $routes->get('master/users/add', 'AdminUsers::add');
    $routes->get('master/users/add', 'AdminUsers::add');
    $routes->get('master/users/edit/(:any)', 'AdminUsers::edit/$1');
    $routes->post('master/users/update/(:any)', 'AdminUsers::update/$1');
    $routes->get('master/users/delete/(:any)', 'AdminUsers::deleteUsers/$1');


    // Admin Jam Kerja
    $routes->get('master/jam-kerja', 'AdminJamkerja::index');
    $routes->get('master/jam-kerja/add', 'AdminJamkerja::add');
    $routes->post('master/jam-kerja/save', 'AdminJamkerja::save');
    $routes->get('master/jam-kerja/edit/(:any)', 'AdminJamkerja::edit/$1'); // Halaman edit jam kerja
    $routes->post('master/jam-kerja/update/(:any)', 'AdminJamkerja::update/$1'); // Proses update jam kerja
    $routes->get('master/jam-kerja/delete/(:any)', 'AdminJamkerja::deleteJamKerja/$1'); // Halaman delete jam kerja

    // Absensi
    $routes->get('absensi', 'AdminAbsensi::index');
    $routes->get('absensi/add', 'AdminAbsensi::add');
    $routes->post('absensi/save', 'AdminAbsensi::save');
    $routes->get('absensi/edit/(:any)', 'AdminAbsensi::edit/$1');
    $routes->post('absensi/update/(:any)', 'AdminAbsensi::update/$1');
    $routes->get('absensi/delete/(:any)', 'AdminAbsensi::deleteAbsensi/$1');

    $routes->get('absensi/rekapan', 'AdminAbsensi::rekapan');
    $routes->get('absensi/exportPdf', 'AdminAbsensi::exportPdf');


});

$routes->group('karyawan', ['filter' => 'authenticate'], function ($routes) {
    // $routes->group("Admin", ["filter" => "auth"], function ($routes) {
    $routes->get('dashboard', 'KaryawanDashboard::index', ['filter' => 'authenticate']);

 // Ka
    $routes->get('absensi', 'KaryawanAbsensi::index');
    $routes->get('absensi/add', 'KaryawanAbsensi::add');
    $routes->post('absensi/save', 'KaryawanAbsensi::save');
    $routes->get('absensi/edit/(:any)', 'KaryawanAbsensi::edit/$1');
    $routes->post('absensi/update/(:any)', 'KaryawanAbsensi::update/$1');
    $routes->get('absensi/delete/(:any)', 'KaryawanAbsensi::deleteKaryawan/$1');
    $routes->get('absensi/rekap-bulanan', 'KaryawanAbsensi::rekapBulanan');
    $routes->get('absensi/rekap-bulanan/(:num)/(:num)', 'KaryawanAbsensi::rekapBulanan/$1/$2');
    $routes->get('absensi/export-pdf', 'KaryawanAbsensi::exportPdf');





    // $routes->get('dashboard', 'PelangganDashboard::index');
    $routes->get('profil', 'KaryawanProfil::index');
    $routes->post('users/update', 'KaryawanProfil::update');
});
