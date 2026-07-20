<?php 

namespace App\Models;
use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'solde';
    protected $primaryKey = 'idSolde';
    protected $allowedFields = ['idSolde', 'idUtilisateur', 'montant'];
}