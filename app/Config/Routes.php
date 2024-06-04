<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->set404Override('App\Controllers\ErrorController::show404');

$routes->group('', ['filter' => 'isLoggedIn'], function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/ranking', 'DashboardController::ranking');

    $routes->get('/detail-siswa/(:any)', 'SiswaController::detailSiswa/$1');

    $routes->get('/lapor', 'LaporController::index');
    $routes->post('/lapor', 'LaporController::index');

    $routes->get('/daftar-perilaku', 'DetailPerilakuController::index');
    $routes->post('/daftar-perilaku', 'DetailPerilakuController::index');
    $routes->post('/daftar-perilaku/delete/(:any)', 'DetailPerilakuController::delete/$1');

    $routes->post('/lapor/siswa/penghargaan/(:any)', 'LaporController::insertPenghargaan/$1');
    $routes->post('/lapor/siswa/pelanggaran/(:any)', 'LaporController::insertPelanggaran/$1');


    $routes->group('settings', ['filter' => 'rbac'], function ($routes) {
        $routes->get('tata-tertib', 'TataTertibController::index');
        $routes->get('tata-tertib/export', 'TataTertibController::export');
        $routes->post('tata-tertib/import', 'ImportController::importDataTataTertib');

        $routes->post('tata-tertib', 'TataTertibController::index');
        $routes->post('tata-tertib/delete/(:any)', 'TataTertibController::delete/$1');
        $routes->post('tata-tertib/insert', 'TataTertibController::insert');
        $routes->post('tata-tertib/update/(:any)', 'TataTertibController::update/$1');

        $routes->get('siswa', 'SiswaController::index');
        $routes->get('siswa/export', 'SiswaController::export');
        $routes->post('siswa/import', 'ImportController::importDataSiswa');

        $routes->post('siswa', 'SiswaController::index');
        $routes->post('siswa/delete/(:any)', 'SiswaController::delete/$1');
        $routes->post('siswa/insert', 'SiswaController::insert');
        $routes->post('siswa/update/(:any)', 'SiswaController::update/$1');

        $routes->get('guru', 'GuruController::index');
        $routes->get('guru/export', 'GuruController::export');
        $routes->post('guru/import', 'ImportController::importDataGuru');


        $routes->post('guru', 'GuruController::index');
        $routes->post('guru/delete/(:any)', 'GuruController::delete/$1');
        $routes->post('guru/insert', 'GuruController::insert');
        $routes->post('guru/update/(:any)', 'GuruController::update/$1');

        $routes->post('/lapor/siswa/searchSiswa', 'SiswaController::searchSiswa');
    });
});

// Rute yang tidak dilindungi oleh filter 'auth'
$routes->get('/', 'HomeController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/unauthorized', 'ErrorController::unauthorized');
