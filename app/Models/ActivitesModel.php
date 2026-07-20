<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivitesModel extends Model
{
    protected $table = 'Activites';
    protected $primaryKey = 'id_Activite';
    protected $allowedFields = ['id_Activite', 'id_Objectif', 'libelle', 'duree', 'variation_poids'];


    function getActiviteObjectid()
    {
        return $this->db->table($this->table)
            ->select('Activites.*, Objectif.libelle lib_objectif')
            ->join('Objectif', 'Objectif.id_Objectif = Activites.id_Objectif')
            ->get()
            ->getResultArray();
    }
}
