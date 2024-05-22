<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/dashboard', 'DashboardController::index');

$routes->get('/daftar-siswa', 'SiswaController::daftarSiswa');
$routes->get('/daftar-siswa/(:num)', 'SiswaController::detailSiswa/$1');


$routes->get('/settings/tata-tertib', 'TataTertibController::index');
$routes->post('/settings/tata-tertib/delete/(:any)', 'TataTertibController::delete/$1');
$routes->post('/settings/tata-tertib/insert', 'TataTertibController::insert');
$routes->post('/settings/tata-tertib/update/(:any)', 'TataTertibController::update/$1');


$routes->get('/settings/siswa', 'SiswaController::index');
$routes->post('/settings/siswa/delete/(:any)', 'SiswaController::delete/$1');
$routes->post('/settings/siswa/insert', 'SiswaController::insert');
$routes->post('/settings/siswa/update/(:any)', 'SiswaController::update/$1');


$routes->get('/settings/guru', 'GuruController::index');
$routes->post('/settings/guru/delete/(:any)', 'GuruController::delete/$1');
$routes->post('/settings/guru/insert', 'GuruController::insert');
$routes->post('/settings/guru/update/(:any)', 'GuruController::update/$1');


$routes->get('/detail-siswa/(:any)', 'SiswaController::detailSiswa/$1');
