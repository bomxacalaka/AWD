<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ModelAPIpost extends ResourceController
{
    public function show($id = null)
    {

        $json = $this->request->getJSON();
        
        if($json){
            return $this->respond($json);
        }else{
            return $this->failNotFound('No data found');
        }
    }
}
