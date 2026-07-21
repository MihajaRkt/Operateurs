<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'epargne';
    protected $primaryKey = 'idEpargne';
    protected $allowedFields = ['idEpargne', 'pourcentage', 'idUtilisateur'];

    public function getEpargneByClient($id)
    {
        return $this->db
            ->table($this->table)
            ->select("epargne.idEpargne idEpargne, epargne.pourcentage pourcentage")
            ->join(
                "utilisateurs",
                "epargne.idUtilisateur = utilisateurs.idUtilisateur",
            )
            ->where("epargne.idUtilisateur", $id)
            ->get()
            ->getResultArray();
    }


}
