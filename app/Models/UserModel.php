<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

   
   public function login($email=null,$pass=null){

      if($this->where(['email'=>$email,'password'=>$pass])->countAllResults()==1) return 1;
      return -1;

   }
   

}