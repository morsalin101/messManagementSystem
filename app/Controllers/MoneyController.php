<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\MealModel;
use App\Models\IndividualMealModel;
use App\Models\MoneyModel;

class MoneyController extends BaseController
{
    public function money()
    {
        $data['page_title'] = "Money";
        $data['name'] =  $this->session->get('name');
        $data['role'] = $this->session->get('role');
        $data['active'] = 'money';
        return view('partials/header',$data)
        .view('money')
        .view('partials/footer');

       
    }
    public function ajax($method){

       if($method == 'get-depositions'){
           $moneyModel = new MoneyModel();
           $userModel = new UserModel();
           $mealModel = new MealModel();
           $mealData = $mealModel->where('status', 'active')->first();
           $meal_uuid = $mealData['meal_uuid']; 
           $id = $this->request->getGet('id');
           $userData = $userModel->find($id);
           $uuid = $userData['uuid'];
           $money = $moneyModel
                   ->where('member_uuid', $uuid)
                   ->where('meal_uuid',$meal_uuid)
                   ->findAll();
          
           return $this->response->setJSON($money);
       }
       if($method == 'add-money'){
        $moneyModel = new MoneyModel();
        $id = $this->request->getGet('id');
        $userModel = new UserModel();
        $userData = $userModel->find($id);
        $uuid = $userData['uuid'];
        $mealModel = new MealModel();
        $mealData = $mealModel->where('status', 'active')->first();
        $meal_uuid = $mealData['meal_uuid'];
        $json = $this->request->getJSON();

        $data = [
            'member_uuid' => $uuid ,
            'meal_uuid' =>   $meal_uuid,
            'deposite' => $json->deposite,
            'date' => $json->date,
        ];
    
        $flag = $moneyModel->insert($data, false);
        if ($flag !== false) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Successfully']);
        }

       }

    }

}
