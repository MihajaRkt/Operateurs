<?php

namespace App\Models;

use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table = 'promotion';
    protected $primaryKey = 'idPromotion';
    protected $allowedFields = ['idPromotion', 'pourcentage'];


    public function savePromm(float $pourcentage)
    {
        $this->update(1, ['pourcentage' => $pourcentage]);
    }
}
