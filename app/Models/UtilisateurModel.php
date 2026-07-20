<?php

namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'idUtilisateur';
    protected $allowedFields = ['idUtilisateur', 'nom', 'telephone', 'motdepasse'];
}