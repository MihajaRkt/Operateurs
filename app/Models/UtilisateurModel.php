<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = "utilisateurs";
    protected $primaryKey = "idUtilisateur";
    protected $allowedFields = [
        "idUtilisateur",
        "nom",
        "telephone",
        "motdepasse",
    ];

    public function getByTelephone(string $telephone): ?array
    {
        return $this->where("telephone", $telephone)->first();
    }

    public function sameOperateur(string $tel1, string $tel2): bool
    {
        $prefix1 = substr($tel1, 0, 3);
        $prefix2 = substr($tel2, 0, 3);

        if ($prefix1 === $prefix2) {
            return true;
        }
        return false;
    }
}
