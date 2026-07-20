<?php

namespace App\Models;
use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table = 'Categories';
    protected $primaryKey = 'idCategorie';
    protected $allowedFields = ['idCategorie', 'libelle'];
}