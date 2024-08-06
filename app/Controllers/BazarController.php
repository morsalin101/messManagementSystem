<?php

namespace App\Controllers;

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
            
            $bazars = $bazarModel->findAll();
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
            $json = $this->request->getJSON();

            $data = [
                'title' => $json->title,
                'amount' => $json->amount,
                'date' => $json->date,
            ];

            $flag = $bazarModel->insert($data, false);
            if ($flag !== false) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Successfully']);
            }
        }
    }

}
