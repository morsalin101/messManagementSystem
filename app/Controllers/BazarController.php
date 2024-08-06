<?php

namespace App\Controllers;
use App\Models\BazarModel;
use App\Models\UserModel;
use App\Models\MealModel;
use App\Models\IndividualMealModel;

class BazarController extends BaseController
{
    public function bazar()
    {
        $data['page_title'] = "Bazar";
        $data['name'] =  $this->session->get('name');
        $data['role'] = $this->session->get('role');
        $data['active'] = 'bazar';
        return view('partials/header',$data)
         .view('bazar', $data)
         .view('partials/footer');

       
    }
    public function ajax($method)
    {
      
            if ($method == 'get-all-bazars') {
                $bazarModel = new BazarModel();
                $mealModel = new MealModel();
                $userModel = new UserModel();
        
                // Fetch active meal data
                $mealData = $mealModel->where('status', 'active')->first();
                if ($mealData==null) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Please start a new meal first']);
                }
                $meal_uuid = $mealData['meal_uuid']; 
        
                // Fetch bazars for the active meal
                $bazars = $bazarModel->where('meal_uuid', $meal_uuid)->findAll();
               
                // Enhance bazars with user names
                foreach ($bazars as &$bazar) {
                    $member_uuid = $bazar['member_uuid'];
                    $user = $userModel->where('uuid', $member_uuid)->first();
                    $bazar['member_name'] = $user['name'];
                }
               
                // Return the enhanced bazar data as JSON
                return $this->response->setJSON($bazars);
            }
        
        

        if ($method == 'delete-bazar') {
            $bazarModel = new BazarModel();
            $id = $this->request->getVar('id');
            $bazarModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Delete Successfully']);
        }

        if ($method == 'add-bazar') {
            $bazarModel = new BazarModel();
            $mealModel = new MealModel();
            $json = $this->request->getJSON();
            $uuid = $this->session->get('uuid');
            $mealData = $mealModel->where('status', 'active')->first();
            if (!$mealData) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No active meal found']);
            }
                $meal_uuid = $mealData['meal_uuid']; 
            $data = [
                'meal_uuid' => $meal_uuid,
                'total' => $json->total,
                'date' => $json->date,
                'member_uuid'=> $uuid,
                'details'  => $json->details
            ];

            $flag = $bazarModel->insert($data, false);
            if ($flag !== false) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Money added successfully']);
            }
        }
    }

}
