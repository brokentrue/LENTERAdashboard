
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::storeRegister');
$routes->post('/logout', 'Auth::logout', ['filter' => 'csrf']);

// Dashboard
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/admin/users', 'UserManagement::index', ['filter' => 'admin']);

$routes->post(
    '/admin/users/approve/(:num)',
    'UserManagement::approve/$1',
    ['filter' => ['admin', 'csrf']]
);

// Progress / Detail SOP
$routes->get('/progress', 'Progress::index', ['filter' => 'auth']);
$routes->get('/progress/(:num)', 'Progress::detail/$1', ['filter' => 'auth']);

// Knowledge Repository
$routes->get(
    '/repository',
    'Repository::index',
    ['filter' => 'auth']
);

$routes->post(
    '/repository/upload',
    'Repository::upload',
    ['filter' => ['auth', 'csrf']]
);

$routes->get(
    '/repository/download/(:num)',
    'Repository::download/$1',
    ['filter' => 'auth']
);

$routes->get(
    '/repository/preview/(:num)',
    'Repository::preview/$1',
    ['filter' => 'auth']
);

// Testing
// $routes->get('/progress-test/initialize', 'ProgressTest::initialize');
