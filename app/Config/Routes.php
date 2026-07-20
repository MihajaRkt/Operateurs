<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/accueil', 'Home::accueil');

// Operateurs
$routes->get('/loginOperateur', 'Home::operateur');
$routes->get('/loginClient', 'Home::client');

$routes->post('/clientLogin', 'Utilisateur::login');
$routes->post('/loginOperateur', 'Operateur::login');

$routes->get('/accueilOperateur', 'Operateur::accueil');

$routes->get('/ajouterFrais', 'Operateur::formFrais');
$routes->get('/modifierFrais/(:num)', 'Operateur::formModifierFrais/$1');
$routes->post('/ajouterFrais', 'Operateur::ajouterFrais');
$routes->post('/modifierFrais/(:num)', 'Operateur::modifierFrais/$1');

$routes->get('/ajouterPrefixe', 'Operateur::formPrefixe');
$routes->post('/ajouterPrefixe', 'Operateur::ajouterPrefixe');

//Client
$routes->get('/', 'Home::client');

$routes->get('/retrait-form', 'Home::retraitForm');
$routes->get('/depot-form', 'Home::depotForm');
$routes->get('/transfert-form', 'Home::transfertForm');
