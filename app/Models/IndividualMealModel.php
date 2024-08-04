<?php

namespace App\Models;

use CodeIgniter\Model;

class IndividualMealModel extends Model
{
    protected $table            = 'individual_meal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

}
