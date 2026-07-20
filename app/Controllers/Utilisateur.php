<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\ProduitModel;
use App\Models\CategorieModel;

class Utilisateur extends BaseController
{
    public function login()
    {
        $model = new UtilisateurModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();
        if (!$user || $password != $user['motdepasse']) {
            return view('auth/login', [
                'user' => null,
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }

        session()->set('user', [
            'id' => $user['idUtilisateur'],
            'nom' => $user['nom'],
            'email' => $user['email'],
        ]);

        $produitModel= new ProduitModel();
        $produits= $produitModel -> getDetailsProduits();

        $categorieModel= new CategorieModel();
        $categories= $categorieModel -> findAll();

        return view('pages/accueil', [
            'produits' => $produits,
            'categories' => $categories
        ]);

    }

    public function showLogin()
    {
        return view('auth/login');
    }

    public function showSignUp()
    {
        return view('signup');
    }

    public function showSignUp2()
    {
        $data = [
            'nom' => $this->request->getPost('nom'),
            'genre' => $this->request->getPost('genre'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        $errors = [];
        if (!$data['nom'] || strlen(trim($data['nom'])) < 3) {
            $errors['nom'] = "Votre nom doit avoir au moins 3 caractères.";
        }
        if (!$data['password'] || strlen($data['password']) < 8) {
            $errors['password'] = "Le mot de passe doit avoir au moins 8 caractères.";
        }
        if (!$data['email'] || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email obligatoire ou invalide.";
        }
        if (!$data['genre'] || ($data['genre'] !== 'M' && $data['genre'] !== 'F')) {
            $errors['genre'] = "Genre obligatoire.";
        }

        if (!empty($errors)) {
            return view('signup', [
                'errors' => $errors,
                'old' => [
                    'nom' => $data['nom'],
                    'genre' => $data['genre'],
                    'email' => $data['email'],
                ]
            ]);
        }

        return view('signupSante', [
            'infos' => $data,
        ]);
    }

    public function register()
    {
        $infos = $this->request->getPost();
        $sante = [
            'nom' => $infos['nom'],
            'genre' => $infos['genre'],
            'email' => $infos['email'],
            'motdepasse' => $infos['password'],
            'taille' => $this->request->getPost('taille'),
            'poids' => $this->request->getPost('poids'),
            'estAdmin' => 0
        ];

        $utilisateurmodel = new UtilisateurModel();

        if (!$utilisateurmodel->insert($sante)) {
            return view('signup', [
                'errors' => $utilisateurmodel->errors(),
                'old' => $infos
            ]);
        } else {
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

}
