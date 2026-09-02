<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('progress', 'Progress::index');


$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
