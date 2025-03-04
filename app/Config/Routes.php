<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/api/user', 'Userapi::index');
$routes->post('/api/user', 'Userapi::create');
$routes->put('/api/user/(:num)', 'Userapi::update/$1');
$routes->delete('/api/user/(:num)', 'Userapi::delete/$1');
