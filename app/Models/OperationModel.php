<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = "operations";
    protected $primaryKey = "idOperation";
    protected $allowedFields = [
        "idOperation",
        "idOperateur",
        "idType_operation",
        "idFrais",
        "idUtilisateur",
        "date_operation",
        "montant",
    ];

    public function enregistrerOperation(array $data): bool
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function getHistoriqueByUtilisateur(int $userId): array
    {
        return $this->db
            ->table($this->table)
            ->select(
                'operations.idOperation, operations.date_operation, operations.montant,
                      type_operation.nom AS type_nom,
                      frais.montant AS frais_montant',
            )
            ->join(
                "type_operation",
                "type_operation.idType_operation = operations.idType_operation",
                "left",
            )
            ->join("frais", "frais.idFrais = operations.idFrais", "left")
            ->where("operations.idUtilisateur", $userId)
            ->orderBy("operations.idOperation", "DESC")
            ->get()
            ->getResultArray();
    }
}
