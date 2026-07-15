<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

// Vehicle Routes
$routes->get('vehicle', 'VehicleController::index');
$routes->get('vehicle/create', 'VehicleController::create');
$routes->post('vehicle/store', 'VehicleController::store');
$routes->get('vehicle/edit/(:num)', 'VehicleController::edit/$1');
$routes->post('vehicle/update/(:num)', 'VehicleController::update/$1');
$routes->get('vehicle/delete/(:num)', 'VehicleController::delete/$1');
$routes->get('api/vehicles/available', 'VehicleController::getAvailable');
$routes->get('api/vehicles/type/(:segment)', 'VehicleController::getByType/$1');

// Customer Routes
$routes->get('customer', 'CustomerController::index');
$routes->get('customer/create', 'CustomerController::create');
$routes->post('customer/store', 'CustomerController::store');
$routes->get('customer/edit/(:num)', 'CustomerController::edit/$1');
$routes->post('customer/update/(:num)', 'CustomerController::update/$1');
$routes->get('customer/delete/(:num)', 'CustomerController::delete/$1');
$routes->get('api/customers/active', 'CustomerController::getActive');

// Rental Routes
$routes->get('rental', 'RentalController::index');
$routes->get('rental/create', 'RentalController::create');
$routes->post('rental/store', 'RentalController::store');
$routes->get('rental/view/(:num)', 'RentalController::view/$1');
$routes->post('rental/complete/(:num)', 'RentalController::complete/$1');
$routes->get('rental/cancel/(:num)', 'RentalController::cancel/$1');
$routes->get('api/rentals/active', 'RentalController::getActive');
$routes->get('api/rentals/customer/(:num)', 'RentalController::getCustomerRentals/$1');
