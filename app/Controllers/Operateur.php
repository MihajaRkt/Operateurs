<?php

namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\FraisModel;
use App\Models\OperationModel;

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

        $fraisModel = new FraisModel();

        $desc = $this->request->getPost('desc');
        $min = $this->request->getPost('min');
        $max = $this->request->getPost('max');
        $montant = $this->request->getPost('montant');

        $data = [
            'description' => $desc,
            'montantMin' => $min,
            'montantMax' => $max,
            'montant' => $montant
        ];

        $fraisModel->insert($data);

        return redirect()->to('/accueilOperateur');
    }

    public function formModifierFrais($id)
    {
        $fraisModel = new FraisModel();
        $frais= $fraisModel -> find($id);
        
        return view('operateurs/form-frais', [
            'frais' => $frais
        ]);
    }

    public function modifierFrais($id)
    {

        $fraisModel = new FraisModel();
        $frais= $fraisModel -> find($id);

        $desc = $this->request->getPost('desc');
        $min = $this->request->getPost('min');
        $max = $this->request->getPost('max');
        $montant = $this->request->getPost('montant');

        $data = [
            'description' => $desc,
            'montantMin' => $min,
            'montantMax' => $max,
            'montant' => $montant
        ];

        $fraisModel->update($frais, $data);

        return redirect()->to('/accueilOperateur');
    }

    public function formPrefixe()
    {
        $user = session()->get('user');

        $operateurModel = new OperateurModel();

        $operateurs = $operateurModel
            ->where('operateurs.nom', $user['nom'])
            ->findAll();

        return view('operateurs/form-prefixe', [
            'operateurs' => $operateurs,
            'user' => $user
        ]);
    }

    public function ajouterPrefixe()
    {
        $user = session()->get('user');

        $operateurModel = new OperateurModel();

        $prefixe = $this->request->getPost('prefixe');

        $data = [
            'prefixe' => $prefixe,
            'nom' => $user['nom']
        ];

        $operateurs = $operateurModel
            ->where('operateurs.nom', $user['nom'])
            ->findAll();

        $roles = array_column($operateurs, 'prefixe');

        if (!in_array($prefixe, $roles, true)) {
            $operateurModel -> insert($data);
        }

        return redirect()->to('/ajouterPrefixe');
    }

    public function afficherGain($nom){
        $operationModel= new OperationModel();
        $details = $operationModel -> getDetailsOperations($nom);
        
        $somme= $operationModel -> getGain($nom);

        return view('operateurs/gain', [
            'details' => $details,
            'somme' => $somme
        ]);
    }

    public function afficherClients($nom){
        $operationModel= new OperationModel();
        $details = $operationModel -> getUtilisateurs($nom);
        
        return view('operateurs/clients', [
            'details' => $details
        ]);
    }

    public function afficherGainsSepare(){
        $user= session() -> get('user');

        $operationModel= new OperationModel();
        $details = $operationModel -> getGainOperateur();

        $somme= $operationModel -> getGain($user['nom']);

        return view('operateurs/situation', [
            'details' => $details,
            'somme' => $somme
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

}
