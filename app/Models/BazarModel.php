<?php

namespace App\Models;

use CodeIgniter\Model;

class BazarModel extends Model
{
    protected $table            = 'bazars';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

   

   }
   

