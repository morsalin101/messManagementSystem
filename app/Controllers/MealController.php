<?php

namespace App\Controllers;
use App\Models\MealModel;

class MealController extends BaseController
{
    
        public function meal()
        {
            $data['page_title'] = "Meal";
            $data['name'] =  $this->session->get('name');
            $data['role'] = $this->session->get('role');
            $data['active'] = 'meal';
            return view('partials/header',$data) 
             .view('meal')
             .view('partials/footer');
    
        }

       
        public function ajax($method)
        {
            $mealModel = new MealModel();
        
            if ($method == 'get-all-meals') {
                $meals = $mealModel->findAll();
                return $this->response->setJSON($meals);
            }

            if ($method == 'delete-meal') {
                $id = $this->request->getVar('id');
                $mealModel->delete($id);
                return $this->response->setJSON(['status' => 'success', 'message' => 'Delete Successfully']);
            }
        
            if ($method == 'start-meal') {
                $json = $this->request->getJSON();

                $activeMeals = $mealModel->where('status', 'active')->findAll();
                if (count($activeMeals) > 0)
                return $this->response->setJSON(['status' => 'error', 'message' => 'You Have Already An Active Meal']);

                helper('uid');
                $unique_id = generate_uid();
                $data = [
                    'title' => $json->title,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => "active",
                    'meal_uuid' => $unique_id,
                ];
        
                $flag = $mealModel->insert($data, false);
                if ($flag !== false) {
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Successfully']);
                }
        
            }
        
            if ($method == 'update-meal') {

                $id = $this->request->getGet('id');
                $json = $this->request->getJSON();
        
                $data = [

                    'status' => $json->status,
                    ' finished_at' => date('Y-m-d H:i:s'),
                ];
        
                $flag = $mealModel->set($data)->where('id', $id)->update();
        
                if ($flag) {
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Edited Successfully']);
                } else {
                    return $this->response->setJSON(['status' => 'failed', 'message' => 'Edit Failed']);
                }
            }
        }

}
