<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\MealModel;
use App\Models\IndividualMealModel;
use App\Models\BazarModel;
use App\Models\MoneyModel;



class UserController extends BaseController
{
    
    public function index()
    {
        
         //
         
    }
    public function dashboard()
    {  
       
        $mealModel = new MealModel();
    
        $userModel = new UserModel();
        $individualMealModel = new IndividualMealModel();
         $bazarModel = new BazarModel();
         $moneyModel = new MoneyModel();

        $data['page_title'] = "Dashboard";
        $data['name'] = $this->session->get('name');
        $data['role'] =$this->session->get('role');
        $data['active'] = 'dashboard';
        
       
       
        $mealData = $mealModel->where('status', 'active')->first();
        $meal_uuid = isset($mealData['meal_uuid']) ? $mealData['meal_uuid'] : null;
        $uuid = $this->session->get('uuid');
       
         
        $meals = $individualMealModel->where('meal_uuid', $meal_uuid)
                                     ->where('member_uuid',$uuid)
                                     ->findAll();
        //meal section
       
        $yourMeals = 0;
        foreach ($meals as $meal) {
            $yourMeals += (int)$meal['total'];
        }

        $totalMeals = 0;
        $meals = $individualMealModel->where('meal_uuid', $meal_uuid)->findAll();
        foreach ($meals as $meal) {
            $totalMeals += (int)$meal['total'];
        }
       
        $totalDeposite = $moneyModel
            ->where('meal_uuid', $meal_uuid)
            ->where('member_uuid', $uuid)
            ->findAll();

        $yourDepositeSum = 0;
        foreach ($totalDeposite as $deposite) {
            $yourDepositeSum += (int)$deposite['deposite'];
        }
        

        $totalDepositeOfMeal = $moneyModel
            ->where('meal_uuid', $meal_uuid)
            ->findAll();

        $totalDepositeSum = 0;
        foreach ($totalDepositeOfMeal as $deposite) {
            $totalDepositeSum += (int)$deposite['deposite'];
        }

        $totalBazer = $bazarModel
            ->where('meal_uuid', $meal_uuid)
            ->findAll();
        $totalBazerSum = 0;
        foreach ($totalBazer as $bazer) {
            $totalBazerSum += (int)$bazer['total'];
        }    
       
        //manager section
         $data['total_meals'] = $totalMeals;
         $data['total_money'] = $totalDepositeSum;
         $data['total_bazar'] = $totalBazerSum;
            if($data['total_meals'] == 0){
                $data['meal_rate'] = 0;
            }else{
            $data['meal_rate'] = (float)$data['total_bazar'] / $data['total_meals'];
            }
        
        //member section

         $data['your_total_meals'] = $yourMeals;
         $data['your_deposite'] = $yourDepositeSum;
         $data['your_expense'] = (float)$data['meal_rate'] * $data['your_total_meals'];
         $data['your_balance'] = $data['your_deposite'] - $data['your_expense'];
       
             
       //$bazar = $bazarModel->where('meal_uuid', $meal_uuid)->findAll();



        return view('partials/header',$data)
         .view('dashboard',$data)
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
                $name = $user_data['name'];
               
                $this->session->set([
                    'logged_in' => true,
                    'email' => $email,
                    'uuid' => $uid,
                    'role'=>$user_data['role'],
                    'name'=>$name

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
        $data['name'] =  $this->session->get('name');
        $data['role'] = $this->session->get('role');
        $data['active'] = 'members';
        return view('partials/header',$data) 
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
