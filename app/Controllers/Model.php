<?php

namespace App\Controllers;

use App\Controllers\BaseData;

class Model extends BaseController
{

    public function index()
    {
        return BaseData::getFullPage('models/models');
    }
    public function view( $page = 'index')
    {
        if (! is_file(APPPATH . 'Views/models/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            // throw new PageNotFoundException($page);
            return view('pages/Error');
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return BaseData::getFullPage('models/' . $page, $data);
    }

    public function create()
    {
        return BaseData::getFullPage('models/create');
    }

    public function test()
    {
        return BaseData::getFullPage('models/test');
    }

    // Fuction to manage uploads of models and save to users private folder
    public function uploadModel()
    {
        // Handle form data
        if ($this->request->getMethod() === 'post') {
            helper(['form', 'url']);
    
            // Handle model file upload
            $modelFile = $this->request->getFile('model_file');
            $userId = session()->get('loggedUserId');
            $userDirectory = WRITEPATH . 'uploads/models/' . $userId;
    
            // Create user-specific directory if it doesn't exist
            if (!is_dir($userDirectory)) {
                mkdir($userDirectory, 0700, true);
            }
    
            // Move the uploaded file to the user's directory
            $newFileName = $modelFile->getRandomName();
            $modelFile->move($userDirectory, $newFileName);
    
            // Handle JSON data
            if ($this->request->isAJAX()) {
                $jsonData = $this->request->getJSON();
    
                // Process JSON data as needed
            }
    
            return redirect()->to('model/view/' . $newFileName)->with('success', 'Model uploaded successfully.');
        }
    
        return BaseData::getFullPage('models/upload', ['title' => 'Upload Model']);
    }
    
    
}
