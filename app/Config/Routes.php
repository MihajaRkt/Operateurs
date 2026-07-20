<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/accueil', 'Home::accueil');

$routes->get('/loginOperateur', 'Home::operateur');
$routes->get('/loginClient', 'Home::client');

$routes->post('/clientLogin', 'Utilisateur::login');
$routes->post('/loginOperateur', 'Operateur::login');

$routes->get('/retrait-form', 'Home::retraitForm');
$routes->get('/depot-form', 'Home::depotForm');
$routes->get('/transfert-form', 'Home::transfertForm');
