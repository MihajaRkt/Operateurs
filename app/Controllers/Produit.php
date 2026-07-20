<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\ProduitModel;
use App\Models\CategorieModel;

class Produit extends BaseController
{
    public function produitsFiltre()
    {

        $produitModel = new ProduitModel();
        $produits = $produitModel->getDetailsProduits();

        $categorieModel = new CategorieModel();
        $categories = $categorieModel->findAll();

        $categorie = $this->request->getPost('categorie');

        if ($categorie != null) {
            if ($categorie == 'all') {
                $produits = $produitModel->getDetailsProduits();
            } else {
                $produits = $produitModel->getProduitByCategorie($categorie);
            }
        }

        return view('pages/accueil', [
            'produits' => $produits,
            'categories' => $categories
        ]);

    }

    public function acheterForm($idProduit)
    {
        $produitModel= new ProduitModel();
        $produit= $produitModel -> find($idProduit);

        return view('pages/achat', [
            'produit' => $produit
        ]);
    }

}
