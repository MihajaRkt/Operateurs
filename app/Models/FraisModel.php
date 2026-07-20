<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'idFrais';
    protected $allowedFields = ['idFrais', 'description', 'montantMin', 'montantMax', 'montant'];


    public function getFraisByMontant($montant)
    {
        return $this->where('montantMin <=', $montant)
            ->where('montantMax >=', $montant)
            ->first();
    }
}
