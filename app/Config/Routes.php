<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Auth::register');
$routes->get('/layout', 'Layout::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->post('/admin/login', 'Auth::adminLoginPost');
$routes->get('/admin/login', 'Auth::adminLogin');

$routes->get('/api/check-username', 'Auth::checkUsername');
$routes->get('/api/check-email', 'Auth::checkEmail');

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard/banksoal', 'Banksoal::index');
    $routes->get('dashboard/banksoal/edit/(:segment)', 'Banksoal::edit_bank/$1');
    $routes->get('dashboard/banksoal/(:segment)', 'Banksoal::edit/$1');
    $routes->post('dashboard/banksoal/(:segment)', 'Banksoal::update/$1');
    $routes->post('banksoal/(:segment)', 'Banksoal::update_bank/$1');
    $routes->get('banksoal', 'Banksoal::getBankSoal');
    $routes->get('getbanksoal', 'Banksoal::get');
    $routes->get('dashboard/ujian', 'Ujian::index');
    $routes->get('ujian', 'Ujian::getUjian');
    $routes->get('cek-kode', 'Ujian::cek_kode');
    $routes->get('dashboard/ujian/(:segment)', 'Ujian::edit/$1');
    $routes->post('dashboard/ujian/(:segment)', 'Ujian::update/$1');
    $routes->get('dashboard/user-control', 'UserControl::index');
    $routes->get('dashboard/user-control/(:segment)', 'UserControl::edit/$1');
    $routes->post('dashboard/user-control/edit/(:num)', 'UserControl::userEdit/$1');
    $routes->post('dashboard/user-control/reset/(:num)', 'UserControl::resetPassword/$1');
    $routes->get('user', 'UserControl::getUser');
    $routes->get('mapel', 'Mapel::getMapel');
    $routes->get('api/check-username', 'Auth::adminCheckUsername');
    $routes->get('api/check-email', 'Auth::adminCheckEmail');
});
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('ujian', 'Ujian::user_index');
    $routes->get('ujian_active', 'Ujian::ujian_active');
    $routes->post('ujian/register', 'SantriUjian::register_code');
    $routes->post('save-subscription', 'NotifController::register');
    $routes->get('profile', 'ProfilePeserta::index');
    $routes->get('profile/edit', 'ProfilePeserta::edit');
    $routes->post('profile/edit', 'ProfilePeserta::update');
});
$routes->get('/bank-soal', 'Banksoal::index', ['filter' => 'auth']);
$routes->get('/forgot-password', 'ResetPassword::index');
$routes->post('/forgot-password', 'ResetPassword::userReset');
$routes->get('/forgot-password/result', 'ResetPassword::result');
$routes->get('/reset-password', 'ResetPassword::resetPassword');
$routes->post('/reset-password', 'ResetPassword::updatePassword');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
