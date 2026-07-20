<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'idFrais';
    protected $allowedFields = ['idFrais', 'description', 'montantMin', 'montantMax', 'montant', 'idTypeOperation'];


    public function getFraisByMontant($montant, $idTypeOperation)
    {
        return $this->where('montantMin <=', $montant)
            ->where('montantMax >=', $montant)
            ->where('idTypeOperation', $idTypeOperation)
            ->first();
    }
}
