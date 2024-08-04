<?php

namespace App\Controllers;
use App\Models\UserModel;


class UserController extends BaseController
{
    
    public function index()
    {
        
         //
         
    }
    public function dashboard()
    {
         $data['role'] = $this->session->get('role');
        return view('partials/header')
         .view('dashboard')
         .view('partials/footer');
         
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
           
              
            $flag = $users->login($email,$password); 
            if ($flag > 0) {
                $user_data = $users->where('email',$email)->first();
                $uid = $user_data['uuid'];
                $this->session->set([
                    'logged_in' => true,
                    'email' => $email,
                    'uuid' => $uid,
                    'role'=>$user_data['role']
                ]);
                 
                return $this->response->setJSON(['status' => 'success']);
            } else {
                 return $this->response->setJSON(['status' => 'failed']);
            }

        }
        else{

            if($this->session->get('logged_in')) return redirect()->to('dashboard');
          
            return view('auth/login');
            
        
        }
     
    }
    public function logout() {
        $this->session->destroy();
        return redirect()->route('login');

    }

    public function members()
    {
        $users = new UserModel();
        $data['page_title'] = "Members";
        $data['role'] = $this->session->get('role');

        return
        view('partials/header') 
         .view('members',$data)
         .view('partials/footer');

    }
    public function getMembers()
    {
        $users = new UserModel();
        $data = $users->findAll();
        return $this->response->setJSON($data);
    }



    public function ajax($method)
    {
        $User = new UserModel();
    
        if ($method == 'delete-member') {
            $id = $this->request->getVar('id');
            $User->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Delete Successfully']);
        }
    
        if ($method == 'add-member') {
            $json = $this->request->getJSON();
            helper('uid');
            $unique_id = generate_uid();
            $pass = "123";
            $data = [
                'name' => $json->name,
                'email' => $json->email,
                'password' =>$pass,
                'phone' => $json->phone,
                'role' => $json->role,
                'uuid' => $unique_id,
            ];
    
            $flag = $User->insert($data, false);
            if ($flag !== false) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Added Successfully']);
            }
    
            return $this->response->setJSON(['status' => 'error', 'message' => 'Add Failed']);
        }
    
        if ($method == 'update-member') {
            $formData = $this->request->getJSON(true);
            $id = $this->request->getGet('id');
    
            $data = [
                'name' => $formData['name'],
                'email' => $formData['email'],
                'phone' => $formData['phone'],
                'role' => $formData['role'],
            ];
    
            $flag = $User->set($data)->where('id', $id)->update();
    
            if ($flag) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Edited Successfully']);
            } else {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Edit Failed']);
            }
        }
    }
    


}
