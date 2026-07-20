<?php

namespace App\Models;
use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'idOperation';
    protected $allowedFields = ['idOperation', 'idOperateur', 'idType_operation', 'idFrais', 'idUtilisateur', 'date_operation', 'montant'];


    public function getDetailsOperations($nom){
        return $this->db->table($this->table)
            -> select('operations.*, frais.montant gain, type_operation.nom type,
            operateurs.nom operateur, utilisateurs.nom')
            -> join('frais', 'operations.idFrais = frais.idFrais')
            -> join('type_operation', 'operations.idType_operation = type_operation.idType_operation')
            -> join('operateurs', 'operations.idOperateur = operateurs.idOperateur')
            -> join('utilisateurs', 'operations.idUtilisateur = utilisateurs.idUtilisateur')
            -> get()
            -> getResultArray();
    }

}