<?php

namespace App\Models;
use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'idOperateur';
    protected $allowedFields = ['idOperateur', 'prefixe', 'nom'];

    // Criteres de validation ajoutes pour securiser l'ajout de prefixe
    // par l'operateur (formulaire /ajouterPrefixe).
    protected $validationRules = [
        'prefixe' => 'required|exact_length[3]|numeric',
        'nom'     => 'required|min_length[2]|max_length[100]',
    ];

    protected $validationMessages = [
        'prefixe' => [
            'required'     => 'Le prefixe est obligatoire.',
            'exact_length' => 'Le prefixe doit contenir exactement 3 chiffres.',
            'numeric'      => 'Le prefixe ne doit contenir que des chiffres.',
        ],
        'nom' => [
            'required' => 'Le nom de l\'operateur est obligatoire.',
        ],
    ];

    public function getByTelephone(string $telephone): ?array
    {
        return $this->where('prefixe', substr($telephone, 0, 3))->first();
    }
}