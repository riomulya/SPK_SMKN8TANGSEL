<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/dashboard', 'DashboardController::dashboard');

$routes->get('/daftar-siswa', 'SiswaController::daftarSiswa');
$routes->get('/daftar-siswa/(:num)', 'SiswaController::detailSiswa/$1');

$routes->get('/settings/siswa', 'SettingsController::index');
$routes->get('/settings/guru', 'SettingsController::guru');

$routes->get('/settings/tata-tertib', 'TataTertibController::index');

$routes->post('/settings/tata-tertib/delete/(:any)', 'TataTertibController::delete/$1');
$routes->post('/settings/tata-tertib/insert', 'TataTertibController::insert');
$routes->post('/settings/tata-tertib/update/(:any)', 'TataTertibController::update/$1');
