<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\MealModel;
use App\Models\IndividualMealModel;

class AllMealController extends BaseController
{

   public function allMeals(){

     $data['page_title'] = "All-Meals";
     $data['name'] =  $this->session->get('name');
     $data['role'] = $this->session->get('role');
     $data['active'] = 'meal';
      return view('partials/header',$data)
            .view('allmeals', $data)
            .view('partials/footer');

   }
    
   
    public function ajax($method)
    {
        $individualMealModel = new IndividualMealModel();
    
        if ($method == 'get-all-meals') {
            // Load the models
            $individualMealModel = new IndividualMealModel();
            $userModel = new UserModel();
    
            // Fetch all meals
            $meals = $individualMealModel->findAll();
    
            // Initialize an array to hold the combined data
            $combinedData = [];
    
            // Loop through each meal and fetch the corresponding user data
            foreach ($meals as $meal) {
                $member_uuid = $meal['member_uuid'];
                $user = $userModel->where('uuid', $member_uuid)->first();
    
                // If user is found, combine the data
                if ($user) {
                    $meal['name'] = $user['name']; // Assuming 'name' is the column in UserModel
                    $combinedData[] = $meal;
                }
            }
    
            // Return the combined data as JSON
            return $this->response->setJSON($combinedData);
        }

        if ($method == 'delete-meal') {
            $individualMealModel = new IndividualMealModel();
            $id = $this->request->getVar('id');
            $individualMealModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Delete Successfully']);
        }
    
        
        if ($method == 'update-meal') {
            $individualMealModel = new IndividualMealModel();
            $id = $this->request->getGet('id');
            $json = $this->request->getJSON();
    
            $data = [

                'date' => date('Y-m-d H:i:s'),
                'launch' => $json->launch,
                'dinner' => $json->dinner,
                'guest' => $json->guest
            ];
          
            $flag = $individualMealModel->set($data)->where('id', $id)->update();
    
            if ($flag) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Edited Successfully']);
            } else {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Edit Failed']);
            }
        }
    }

}
