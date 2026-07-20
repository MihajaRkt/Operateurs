<?php

namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'Utilisateur';
    protected $primaryKey = 'idUtilisateur';
    protected $allowedFields = ['idUtilisateur', 'nom', 'email', 'genre', 'motdepasse'];
}