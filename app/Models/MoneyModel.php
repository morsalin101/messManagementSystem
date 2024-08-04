<?php

namespace App\Models;

use CodeIgniter\Model;

class MoneyModel extends Model
{
    protected $table            = 'money';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

   

   }
   

