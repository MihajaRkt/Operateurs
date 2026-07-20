<?php

namespace App\Models;
use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'Produits';
    protected $primaryKey = 'idProduit';
    protected $allowedFields = ['idProduit', 'libelle', 'categorie'];

    function getDetailsProduits(){
        return $this->db->table($this->table)
            -> select('Produits.*, Categories.libelle libCategorie')
            -> join('Categories', 'Categories.idCategorie = Produits.categorie')
            -> get()
            -> getResultArray();
    }

    function getProduitByCategorie($idCategorie){
        return $this->db->table($this->table)
            -> select('Produits.*, Categories.libelle libCategorie')
            -> join('Categories', 'Categories.idCategorie = Produits.categorie')
            -> where('Produits.categorie', $idCategorie)
            -> get()
            -> getResultArray();
    }
}