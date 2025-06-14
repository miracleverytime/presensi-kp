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
    $routes->post('profile/update', 'UserController::updateProfile');
});

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboarda');
});


$routes->get('/hash', 'AuthController::hash');