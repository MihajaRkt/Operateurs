<?php

namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\FraisModel;

class Operateur extends BaseController
{
    public function login()
    {
        $model = new OperateurModel();
        $numero = $this->request->getPost('numero');

        $user = $model->where('prefixe', $numero)->first();

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

        $fraisModel = new FraisModel();
        $frais = $fraisModel->findAll();

        return view('operateurs/accueil', [
            'frais' => $frais,
            'user' => $user
        ]);
    }

    public function accueil()
    {
        $user = session()->get('user');
        $fraisModel = new FraisModel();
        $frais = $fraisModel->findAll();

        return view('operateurs/accueil', [
            'frais' => $frais,
            'user' => $user
        ]);
    }

    public function formFrais()
    {
        return view('operateurs/form-frais');
    }

    public function ajouterFrais()
    {
        $operateur = session()->get('user');

        $fraisModel= new FraisModel();

        $desc = $this->request->getPost('desc');
        $min = $this->request->getPost('min');
        $max = $this->request->getPost('max');
        $montant = $this->request->getPost('montant');

        $data= [
            'description' => $desc,
            'montantMin' => $min,
            'montantMax' => $max,
            'montant' => $montant
        ];

        $fraisModel -> insert($data);

        $frais = $fraisModel->findAll();

        return redirect() -> to('/accueil');
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
