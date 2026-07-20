<?php

namespace App\Models;
use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'idOperateur';
    protected $allowedFields = ['idOperateur', 'prefixe', 'nom'];

    public function getByTelephone(string $telephone): ?array
    {
        return $this->where('prefixe', substr($telephone, 0, 3))->first();
    }
}