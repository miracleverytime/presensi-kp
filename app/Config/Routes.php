<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->post('proses/login', 'AuthController::proseslogin');

$routes->get('register', 'AuthController::register');
$routes->post('register/account', 'AuthController::submit');

$routes->get('forgot', 'AuthController::lupaPassword');
$routes->post('proses/forgot', 'AuthController::prosesLupaPassword');

$routes->get('reset-password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('proses/reset-password', 'AuthController::prosesResetPassword');
$routes->get('test-email', 'AuthController::testEmail');

$routes->get('logout', 'AuthController::login');

$routes->group('user', ['filter' => 'auth:user'], function ($routes) {
    $routes->get('dashboard', 'UserController::dashboardu');
    $routes->get('profile', 'UserController::profile');
    $routes->get('presensi', 'UserController::presensi');
    $routes->get('riwayat', 'UserController::riwayat');
    $routes->get('izin', 'UserController::izin');
    $routes->get('bantuan', 'UserController::bantuan');
    $routes->get('about', 'UserController::about');
    $routes->post('izin/ajukan', 'UserController::ajukanIzin');
    $routes->post('profile/update', 'UserController::updateProfile');
    $routes->post('profile/updatepass', 'UserController::updatePassword');
    $routes->post('presensi/checkin', 'UserController::checkin');
    $routes->post('presensi/checkout', 'UserController::checkout');
    $routes->post('send-message', 'UserController::sendMessage');
    $routes->get('get-messages', 'UserController::getMessages');
});

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboarda');
    $routes->get('presensi', 'AdminController::rekapPresensi');
    $routes->get('peserta', 'AdminController::kelolaPeserta');
    $routes->get('bantuan', 'AdminController::bantuan');
    $routes->get('izin', 'AdminController::kelolaIzin');
    $routes->get('peserta/edit/(:num)', 'AdminController::editPeserta/$1');
    $routes->get('peserta/delete/(:num)', 'AdminController::deletePeserta/$1');
    $routes->post('peserta/update/(:num)', 'AdminController::updatePeserta/$1');
    $routes->get('izin/setuju/(:num)', 'AdminController::setujuIzin/$1');
    $routes->get('izin/tolak/(:num)', 'AdminController::tolakIzin/$1');

});


$routes->get('/hash', 'AuthController::hash');