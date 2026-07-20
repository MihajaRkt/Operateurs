<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commission';
    protected $primaryKey = 'idCommission';
    protected $allowedFields = ['idCommission', 'pourcentage', 'idOperateur'];
}
