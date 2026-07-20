<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/loginOperateur', 'Home::operateur');
$routes->get('/', 'Home::client');

// $routes->get('/', 'Produit::produitsFiltre');
// $routes->get('/login', 'Utilisateur::showLogin');
// $routes->post('/login', 'Utilisateur::login');

// $routes->get('/filtre', 'Produit::produitsFiltre');
// $routes->post('/filtre', 'Produit::produitsFiltre');

// $routes->get('/acheter/(:num)', 'Produit::acheterForm/$1');
// $routes->group('user', ['filter' => 'role:user'], function ($routes) {});
