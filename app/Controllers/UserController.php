<?php

namespace App\Controllers;
use App\Models\UserModel;


class UserController extends BaseController
{
    
    public function index()
    {
        
         //
         
    }
  
    public function login()
    {
        if($this->request->getMethod() === 'POST'){
           
            $users = new UserModel();
              // Get the raw POST data
              $json = $this->request->getJSON();
                $email = $json->email;
                $password = $json->password;
                //$pass = md5($password);
           
               var_dump($json);
               exit;
            $flag = $users->login($email,$password); 
            if ($flag > 0) {
                $user_data = $users->where('email',$email)->first();
                $uid = $user_data['uid'];
                $this->session->set([
                    'logged_in' => true,
                    'email' => $email,
                    'uid' => $uid,
                    'role'=>$user_data['role']
                ]);

             

                return $this->response->setJSON(['status' => 'success']);
            } else {
                 return $this->response->setJSON(['status' => 'failed']);
            }

        }
        else{

            if($this->session->get('logged_in')) return redirect()->to('/');
          
            return view('auth/login');
            
        
        }
     
    }
    public function logout() {
        $this->session->destroy();
        return redirect()->route('login');

    }
}
