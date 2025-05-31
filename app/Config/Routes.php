<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/proses/login', 'AuthController::proseslogin');
$routes->get('/register', 'AuthController::register');


$routes->get('/user', 'AuthController::dashboardu');
$routes->get('/admin', 'AuthController::dashboarda');




$routes->get('/hash', 'AuthController::hash');