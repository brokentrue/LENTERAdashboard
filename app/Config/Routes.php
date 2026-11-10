<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ========================================
// AUTH
// ========================================

$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::storeRegister');

$routes->post('/logout', 'Auth::logout', [
    'filter' => 'csrf'
]);

// ========================================
// DASHBOARD
// ========================================

$routes->get('/dashboard', 'Dashboard::index', [
    'filter' => 'auth'
]);

$routes->get('/admin/users', 'UserManagement::index', [
    'filter' => 'admin'
]);

$routes->post(
    '/admin/users/approve/(:num)',
    'UserManagement::approve/$1',
    ['filter' => ['admin', 'csrf']]
);

// ========================================
// PROGRESS SOP
// ========================================

// Kembali ke Dashboard
$routes->get('/progress', 'Progress::index', [
    'filter' => 'auth'
]);

// Detail SOP berdasarkan ID SOP
$routes->get('/progress/(:num)', 'Progress::detail/$1', [
    'filter' => 'auth'
]);

// Simpan perubahan status sub-tahapan SOP
$routes->post(
    '/progress/(:num)/update',
    'Progress::update/$1',
    ['filter' => ['auth', 'csrf']]
);

// ========================================
// KNOWLEDGE REPOSITORY
// ========================================

// Daftar dokumen
$routes->get('/repository', 'Repository::index', [
    'filter' => 'auth'
]);

// Download dokumen
$routes->get(
    '/repository/download/(:num)',
    'Repository::download/$1',
    ['filter' => 'auth']
);

// Preview dokumen
$routes->get(
    '/repository/preview/(:num)',
    'Repository::preview/$1',
    ['filter' => 'auth']
);

// ========================================
// TESTING (NONAKTIF)
// ========================================

// $routes->get(
//     '/progress-test/initialize',
//     'ProgressTest::initialize'
// );

// INPUT BERKAS RESES - khusus Koordinator, pemeriksaan role juga di controller
$routes->get('/reses', 'Reses::index', ['filter' => 'auth']);
$routes->post('/reses/store', 'Reses::store', ['filter' => ['auth', 'csrf']]);
