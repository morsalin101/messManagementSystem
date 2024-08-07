<?php

namespace App\Controllers;

class SettingController extends BaseController
{
    public function setting()
    {
        
        $data['page_title'] = "Setting";
        $data['name'] = $this->session->get('name');
        $data['role'] = $this->session->get('role');
        $data['active'] = 'setting';

        return view('partials/header', $data)
         . view('setting', $data)
         . view('partials/footer');

    }
    public function ajax($method){
        $users = new \App\Models\UserModel();
        if($method == 'get'){
            $data = $users->where('uuid', $this->session->get('uuid'))->first();
            return $this->response->setJSON($data);
        }

        if($method == 'update'){


        $json = $this->request->getJSON();
        $data = [];
        

        if (isset($json->name)) {
            $data['name'] = $json->name;
        }
        if (isset($json->email)) {
            $data['email'] = $json->email;
        }
        if (isset($json->password)) {
            $data['password'] = $json->password;
        }

        if (!empty($data)) {
            $userModel = new \App\Models\UserModel();
            $flag = $userModel->set($data)->where('uuid', $this->session->get('uuid'))->update();
            
            if ($flag) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Updated successfully']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update user data']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No data to update']);
        }
        }

       

    }

}
