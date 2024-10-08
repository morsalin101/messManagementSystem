<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\MealModel;
use App\Models\IndividualMealModel;

class IndividualMealController extends BaseController
{
    public function ajax($method)
    {
        $individualMealModel = new IndividualMealModel();
    
        if ($method == 'get-todays-meals') {
            // Load the models
            $individualMealModel = new IndividualMealModel();
            $userModel = new UserModel();
        
            // Fetch the current date
            $currentDate = date('Y-m-d');
           
            
            // Fetch all meals for today
            $meals = $individualMealModel->findAll();
        
            // Initialize an array to hold the combined data
            $combinedData = [];
        
            // Loop through each meal and fetch the corresponding user data
            foreach ($meals as $meal) {
                $member_uuid = $meal['member_uuid'];
                $user = $userModel->where('uuid', $member_uuid)
                         ->first();
        
                // If user is found, combine the data
                if ($user) {
                    $meal['name'] = $user['name']; // Assuming 'name' is the column in UserModel
                    $combinedData[] = $meal;
                }
            }
           
        
            // Return the combined data as JSON
            return $this->response->setJSON($combinedData);
        }
        

        // if ($method == 'check-meal-today') {
        //     $mealModel = new IndividualMealModel();
        //     $id = $this->request->getVar('id');
        //     $userModel = new UserModel();
        //     $userData = $userModel->where('id', $id)->first();
        //     $uuid = $userData['uuid'];
        //     $currentDate = date('Y-m-d');
        //     $meal = $mealModel->where('member_uuid', $uuid)->where('date', $currentDate)->first();

        //     if ($meal) {
        //         return $this->response->setJSON(['exists' => true]);
        //     } else {
        //         return $this->response->setJSON(['exists' => false]);
        //     }
        // }
    
        if ($method == 'add-meal') {
            $mealModel = new MealModel();
            $userModel = new UserModel();
            $json = $this->request->getJSON();
            $id = $this->request->getGet('id');
            $userData = $userModel->where('id', $id)->first();
            $uuid = $userData['uuid'];

            $mealData = $mealModel->where('status', 'active')->first();
            if (!$mealData) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Please start a new meal first']);
            }
            $meal_uuid = $mealData['meal_uuid'];
            $individualMealModel = new IndividualMealModel();
            $total = $json->launch + $json->dinner + $json->guest;

            $data = [
              
                'date' => $json->date,
                'launch' => $json->launch,
                'dinner' => $json->dinner,
                'guest' => $json->guest,
                'meal_uuid' => $meal_uuid,
                'member_uuid' => $uuid,
                'total'    => $total
            ];
    
            $flag = $individualMealModel->insert($data, false);
            if ($flag !== false) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Meal Successfully Added']);
            }
    
            return $this->response->setJSON(['status' => 'error', 'message' => 'Add Failed']);
        }
    
        if ($method == 'update-meal') {
            $individualMealModel = new IndividualMealModel();
            $id = $this->request->getGet('id');
            $json = $this->request->getJSON();
            $total = $json->launch + $json->dinner + $json->guest;
    
            $data = [

                'date' => date('Y-m-d H:i:s'),
                'launch' => $json->launch,
                'dinner' => $json->dinner,
                'guest' => $json->guest,
                'total' => $total
            ];
    
            $flag = $individualMealModel->set($data)->where('id', $id)->update();
    
            if ($flag) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Edited Successfully']);
            } else {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Edit Failed']);
            }
        }

        if($method=='your-meal'){
            $individualMealModel = new IndividualMealModel();
            $userModel = new UserModel();
            $mealModel = new MealModel();
            $mealData = $mealModel->where('status', 'active')->first();
            $meal_uuid = $mealData['meal_uuid']; 
            $uuid = $this->session->get('uuid');
            $meal = $individualMealModel
                    ->where('member_uuid', $uuid)
                    ->where('meal_uuid',$meal_uuid)
                    ->findAll();
           
            return $this->response->setJSON($meal);
        }
    }
   

}
