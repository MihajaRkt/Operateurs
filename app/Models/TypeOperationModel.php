<?php 

namespace App\Models;
use CodeIgniter\Model;

class TypeOperationModel extends Model
{
    protected $table = 'type_operation';
    protected $primaryKey = 'idType_operation';
    protected $allowedFields = ['idType_operation', 'nom',];

}