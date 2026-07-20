<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'idFrais';
    protected $allowedFields = ['idFrais', 'description', 'montantMin', 'montantMax', 'montant', 'idTypeOperation'];

    // Criteres de validation ajoutes pour securiser la saisie des frais
    // par l'operateur (formulaire /ajouterFrais et /modifierFrais/:id).
    protected $validationRules = [
        'description' => 'required|min_length[3]|max_length[255]',
        'montantMin'  => 'required|numeric|greater_than_equal_to[0]',
        'montantMax'  => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[10000000]',
        'montant'     => 'required|numeric|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'description' => [
            'required'   => 'La description du frais est obligatoire.',
            'min_length' => 'La description doit contenir au moins 3 caracteres.',
        ],
        'montantMin' => [
            'required' => 'Le montant minimum est obligatoire.',
            'numeric'  => 'Le montant minimum doit etre un nombre.',
        ],
        'montantMax' => [
            'required' => 'Le montant maximum est obligatoire.',
            'numeric'  => 'Le montant maximum doit etre un nombre.',
        ],
        'montant' => [
            'required' => 'Le montant du frais est obligatoire.',
            'numeric'  => 'Le montant du frais doit etre un nombre.',
        ],
    ];

    public function getFraisByMontant($montant, $idTypeOperation)
    {
        return $this->where('montantMin <=', $montant)
            ->where('montantMax >=', $montant)
            ->where('idTypeOperation', $idTypeOperation)
            ->first();
    }
}
