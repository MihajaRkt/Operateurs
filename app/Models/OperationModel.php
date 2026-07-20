<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'idOperation';
    protected $allowedFields = ['idOperation', 'idOperateur', 'idType_operation', 'idFrais', 'idUtilisateur', 'date_operation', 'montant'];

    public function enregistrerOperation(array $data): bool
    {
        return $this->insert($data) !== false;
    }
}
