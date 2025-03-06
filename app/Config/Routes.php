<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/api/user', 'Userapi::index');
$routes->get('/api/user/(:num)', 'UserApi::show/$1');
$routes->post('/api/user', 'Userapi::create');
$routes->put('/api/user/(:num)', 'Userapi::update/$1');
$routes->delete('/api/user/(:num)', 'Userapi::delete/$1');

$routes->get('api/mahasiswa', 'Mahasiswa::index');
$routes->get('api/mahasiswa/(:num)', 'Mahasiswa::show/$1');
$routes->post('api/mahasiswa', 'Mahasiswa::create');
$routes->put('api/mahasiswa/(:num)', 'Mahasiswa::update/$1');
$routes->delete('api/mahasiswa/(:num)', 'Mahasiswa::delete/$1');

$routes->get('api/dosen', 'Dosen::index');
$routes->get('api/dosen/(:num)', 'Dosen::show/$1');
$routes->post('api/dosen', 'Dosen::create');
$routes->put('api/dosen/(:num)', 'Dosen::update/$1');
$routes->delete('api/dosen/(:num)', 'Dosen::delete/$1');

$routes->get('api/ruangan', 'Ruangan::index');
$routes->get('api/ruangan/(:num)', 'Ruangan::show/$1');
$routes->post('api/ruangan', 'Ruangan::create');
$routes->put('api/ruangan/(:num)', 'Ruangan::update/$1');
$routes->delete('api/ruangan/(:num)', 'Ruangan::delete/$1');

$routes->get('api/penguji', 'PengujiSidang::index');
$routes->get('api/penguji/(:num)', 'PengujiSidang::show/$1');

$routes->get('api/jadwal', 'JadwalSidang::index');
$routes->get('api/jadwal/(:num)', 'JadwalSidang::show/$1');
$routes->post('api/jadwal', 'JadwalSidang::create');
$routes->put('api/jadwal/(:num)', 'JadwalSidang::update/$1');
$routes->delete('api/jadwal/(:num)', 'JadwalSidang::delete/$1');