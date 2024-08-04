<?php

namespace App\Models;

use CodeIgniter\Model;

class MealModel extends Model
{
    protected $table            = 'meal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

   

   }
   

