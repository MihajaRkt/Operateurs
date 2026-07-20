<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commission';
    protected $primaryKey = 'idCommission';
    protected $allowedFields = ['idCommission', 'pourcentage', 'idOperateur'];

    public function getByOperateurId(int $operateurId): ?array
    {
        return $this->where('idOperateur', $operateurId)->first();
    }

    public function saveCommission(int $operateurId, float $pourcentage): bool
    {
        $commission = $this->getByOperateurId($operateurId);

        if ($commission) {
            return $this->update($commission['idCommission'], [
                'pourcentage' => $pourcentage,
            ]) !== false;
        }

        return $this->insert([
            'idOperateur' => $operateurId,
            'pourcentage' => $pourcentage,
        ]) !== false;
    }
}
