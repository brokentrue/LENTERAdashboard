<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Dashboard
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Progress / Detail SOP
$routes->get('/progress', 'Progress::index', ['filter' => 'auth']);
$routes->get('/progress/(:num)', 'Progress::detail/$1', ['filter' => 'auth']);

// Testing
$routes->get('/progress-test/initialize', 'ProgressTest::initialize');