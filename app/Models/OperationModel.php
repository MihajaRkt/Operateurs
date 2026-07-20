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
        "idDestinataire",
        "date_operation",
        "montant",
    ];

    public function getDetailsOperations($nom)
    {
        return $this->db
            ->table($this->table)
            ->select(
                'operations.date_operation date, operations.montant montant,
            frais.montant gain,
            type_operation.nom type,
            operateurs.nom operateur, utilisateurs.nom client',
            )
            ->join("frais", "operations.idFrais = frais.idFrais")
            ->join(
                "type_operation",
                "operations.idType_operation = type_operation.idType_operation",
            )
            ->join(
                "operateurs",
                "operations.idOperateur = operateurs.idOperateur",
            )
            ->join(
                "utilisateurs",
                "operations.idUtilisateur = utilisateurs.idUtilisateur",
            )
            ->where("operateurs.nom", $nom)
            ->get()
            ->getResultArray();
    }

    public function getGain($nom)
    {
        $sql = $this->db
            ->table($this->table)
            ->selectSum("frais.montant", "gains")
            ->join(
                "operateurs",
                "operations.idOperateur = operateurs.idOperateur",
            )
            ->join("frais", "operations.idFrais = frais.idFrais")
            ->where("operateurs.nom", $nom)
            ->get()
            ->getRowArray();

        return $sql["gains"];
    }

    public function getUtilisateurs($nom)
    {
        return $this->db
            ->table($this->table)
            ->select(
                'operations.date_operation date, solde.montant solde,
            operateurs.nom operateur, utilisateurs.nom client, operations.idUtilisateur idClient',
            )
            ->join(
                "operateurs",
                "operations.idOperateur = operateurs.idOperateur",
            )
            ->join(
                "utilisateurs",
                "operations.idUtilisateur = utilisateurs.idUtilisateur",
            )
            ->join("solde", "operations.idUtilisateur = solde.idUtilisateur")
            ->where("operateurs.nom", $nom)
            ->get()
            ->getResultArray();
    }

    public function enregistrerOperation(array $data): bool
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function getHistoriqueByUtilisateur(int $userId): array
    {
        return $this->db
            ->table($this->table)
            ->select(
                'operations.idOperation,
                 operations.date_operation,
                 operations.montant,
                 operations.destinataire,
                 type_operation.nom AS type_nom,
                 frais.montant      AS frais_montant',
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

    public function getGainOperateur()
    {
        return $this->db
            ->table($this->table)
            ->select(
                'operations.date_operation date, operations.montant montant,
            frais.montant gain,
            type_operation.nom type,
            operateurs.nom operateur, utilisateurs.nom client',
            )
            ->join("frais", "operations.idFrais = frais.idFrais")
            ->join(
                "type_operation",
                "operations.idType_operation = type_operation.idType_operation",
            )
            ->join(
                "operateurs",
                "operations.idOperateur = operateurs.idOperateur",
            )
            ->join(
                "utilisateurs",
                "operations.idUtilisateur = utilisateurs.idUtilisateur",
            )
            ->get()
            ->getResultArray();
    }

    public function getGainByFrais($idType_operation, $nom)
    {
        $sql= $this->db->table($this->table)
            ->selectSum('frais.montant', 'gains')
            ->join('operateurs', 'operations.idOperateur = operateurs.idOperateur')
            ->join('type_operation', 'operations.idType_operation = type_operation.idType_operation')
            ->join('frais', 'operations.idFrais = frais.idFrais')
            ->where('operations.idType_operation', $idType_operation)
            ->where('operateurs.nom', $nom)
            ->get()
            ->getRowArray();

        return $sql["gains"];
    }

        public function getGainFiltre($idType_operation, $nom)
    {
        return $this->db->table($this->table)
            ->select('operations.date_operation date, operations.montant montant,
            frais.montant gain,
            type_operation.nom type,
            operateurs.nom operateur, utilisateurs.nom client')
            ->join('frais', 'operations.idFrais = frais.idFrais')
            ->join('type_operation', 'operations.idType_operation = type_operation.idType_operation')
            ->join('operateurs', 'operations.idOperateur = operateurs.idOperateur')
            ->join('utilisateurs', 'operations.idUtilisateur = utilisateurs.idUtilisateur')
            ->where('operations.idType_operation', $idType_operation)
            ->where('operateurs.nom', $nom)
            ->get()
            ->getResultArray();
    }

    public function insertMany($liste)
    {
        foreach ($liste as $row) {
            $this->db->table($this->table)->insert($row);
        }
    }
}
