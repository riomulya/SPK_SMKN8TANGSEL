<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Pages::dashboard');

$routes->get('/daftar-siswa', 'Siswa::daftarSiswa');
$routes->get('/daftar-siswa/(:num)', 'Siswa::detailSiswa/$1');

$routes->get('/penghargaan', 'Pages::penghargaan');
$routes->get('/pelanggaran', 'Pages::pelanggaran');

$routes->get('/peraturan', 'TataTertib::index');
