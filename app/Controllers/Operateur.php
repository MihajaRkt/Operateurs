<?php

namespace App\Controllers;

use App\Models\OperateurModel;

class Operateur extends BaseController
{
    public function login()
    {
        $model = new OperateurModel();
        $numero = $this->request->getPost('numero');

        $user = $model->where('prefixe', $numero)->first();

        dd($user);

        if (!$user) {
            return view('auth/login-operateur', [
                'user' => null,
                'error' => 'Numero non disponible'
            ]);
        }

        session()->set('user', [
            'id' => $user['idOperateur'],
            'nom' => $user['nom'],
            'numero' => $user['prefixe'],
        ]);

        // $produitModel= new ProduitModel();
        // $produits= $produitModel -> getDetailsProduits();

        // $categorieModel= new CategorieModel();
        // $categories= $categorieModel -> findAll();

        return view('operateurs/accueil', [
            'user' => $user
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

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

}
