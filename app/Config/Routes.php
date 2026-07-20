<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get("/", "Home::index");
$routes->get("/accueil", "Home::accueil");

// Operateurs
$routes->get("/loginOperateur", "Home::operateur");
$routes->get("/loginClient", "Home::client");

$routes->post("/clientLogin", "Utilisateur::login");
$routes->post("/loginOperateur", "Operateur::login");

// $routes->get('/accueil', 'Operateur::accueil');
$routes->get("/accueilOperateur", "Operateur::accueil");

$routes->get("/ajouterFrais", "Operateur::formFrais");
$routes->get("/modifierFrais/(:num)", 'Operateur::formModifierFrais/$1');
$routes->post("/ajouterFrais", "Operateur::ajouterFrais");
$routes->post("/modifierFrais/(:num)", 'Operateur::modifierFrais/$1');

$routes->get("/ajouterPrefixe", "Operateur::formPrefixe");
$routes->post("/ajouterPrefixe", "Operateur::ajouterPrefixe");

$routes->get('/voirGain/(:any)', 'Operateur::afficherGain/$1');
$routes->get('/voirCommission', 'Operateur::commission');
$routes->post('/voirCommission', 'Operateur::modifierCommission');

$routes->get('/compteClients/(:any)', 'Operateur::afficherClients/$1');
$routes->get('/profil/(:num)', 'Operateur::historique/$1');

$routes->get('/gainSepare', 'Operateur::afficherGainsSepare');

$routes->post('/filtreGain', 'Operateur::filtrerGain');

$routes->get("/logout", "Operateur::logout");

//Client
$routes->get("/", "Home::client");

$routes->get("/retrait-form", "Home::retraitForm");
$routes->get("/depot-form", "Home::depotForm");
$routes->get("/transfert-form", "Home::transfertForm");

$routes->post("/retrait/save", "Utilisateur::retrait");
$routes->post("/depot/save", "Utilisateur::depot");
$routes->post("/transfert/save", "Utilisateur::transfert");

$routes->get("/historique", "Utilisateur::historique");
