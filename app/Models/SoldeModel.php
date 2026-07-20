<?php 

namespace App\Models;
use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'solde';
    protected $primaryKey = 'idSolde';
    protected $allowedFields = ['idSolde', 'idUtilisateur', 'montant'];

    public function getByUtilisateurId(int $userId): ?array
    {
        return $this->where('idUtilisateur', $userId)->first();
    }

    public function ajouterMontant(int $userId, float $montant): bool
    {
        return $this->db->table($this->table)
            ->where('idUtilisateur', $userId)
            ->set('montant', 'montant + ' . $montant, false)
            ->update();
    }

    public function retirerMontant(int $userId, float $montant): bool
    {
        return $this->db->table($this->table)
            ->where('idUtilisateur', $userId)
            ->set('montant', 'montant - ' . $montant, false)
            ->update();
    }
}