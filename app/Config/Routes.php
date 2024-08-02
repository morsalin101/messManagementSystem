<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['GET','POST'],'/login', 'UserController::login');
$routes->get('logout', 'UserController::logout');
