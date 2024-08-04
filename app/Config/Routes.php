<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['GET','POST'],'login', 'UserController::login');
$routes->get('logout', 'UserController::logout');
$routes->get('dashboard', 'UserController::dashboard');
$routes->match(['GET','POST'],'members', 'UserController::members');
$routes->get('get-members', 'UserController::getMembers');
$routes->match(['POST','PUT','DELETE'],'ajax/(:any)', 'UserController::ajax/$1');
$routes->match(['POST','PUT','DELETE','GET'],'meal/ajax/(:any)', 'MealController::ajax/$1');
$routes->match(['GET','POST','PUT'],'individual-meal/ajax/(:any)', 'IndividualMealController::ajax/$1');
$routes->get('meal', 'MealController::meal');
