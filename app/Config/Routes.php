<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/proses/login', 'AuthController::proseslogin');
$routes->get('/register', 'AuthController::register');


$routes->group('user', ['filter' => 'auth:user'], function ($routes) {
    $routes->get('dashboard', 'AuthController::dashboardu');
});

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'AuthController::dashboarda');
});


$routes->get('/hash', 'AuthController::hash');