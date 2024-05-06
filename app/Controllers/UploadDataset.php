<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseData;
use CodeIgniter\Controller;

class UploadDataset extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }
    public function uploads()
    {
        $usersModel = new UserModel();
        $loggedUserId = session()->get('loggedUserId');
        $userInfo = $usersModel->find($loggedUserId);
        $data = [
            'title' => "Dataset Upload",
            'name' => $userInfo['firstname_usr'],
            'userID' => $userInfo['id_usr'],
        ];
        return BaseData::getFullPage('dataset/upload', ['data' => $data]);
    }

    public function index()
    {
        // Get the user's session ID
        $userId = session()->get('loggedUserId');

        $data = [
            'title' => "My Datasets",
            'userID' => $userId,
        ];

        // Define the directory path
        $userDirectory = WRITEPATH . 'uploads/' . $userId . '/datasets';

        // Check if the directory exists
        if (is_dir($userDirectory)) {
            // List all files in the directory
            $files = array_diff(scandir($userDirectory), array('.', '..'));

            // You can now do whatever you want with the $files array
            // For example, you can pass it to a view to display the list to the user
            return BaseData::getFullPage('dataset/list', ['files' => $files, 'data' => $data]);
        } else {
            // Handle the case where the directory doesn't exist
            return "User directory not found";
        }
    }

    // For uploading machine learning models
    public function do_upload()
    {
        helper(['form', 'url']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'dataset' => 'uploaded[dataset]|max_size[dataset,100000]',
            ];
            $errors = [
                'profile_picture' => [
                    'uploaded' => 'Please select a valid dataset file to upload.',
                    'max_size' => 'The uploaded dataset exceeds the maximum allowed size of 1GB.',
                ],
            ];
            if ($this->validate($rules, $errors)) {
                $modelUpload = $this->request->getFile('dataset');
                $newName = $modelUpload->getName();
                // Create user-specific directory
                $userDirectory = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/datasets';
                if (!is_dir($userDirectory)) {
                    mkdir($userDirectory, 0700, true);
                }
    
                // Check if the user already has a profile picture and delete it
                $existingPicturePath = $userDirectory . '/' . $newName;
                if (file_exists($existingPicturePath)) {
                    unlink($existingPicturePath);
                }
    
                // Move the uploaded file to the user's directory
                $modelUpload->move($userDirectory, $newName);
                
    
                return redirect()->to('/dataset')->with('success', 'Model uploaded successfully!');
            } else {
                return redirect()->to('/dataset')->with('error', 'Model upload failed!' . $this->validator->listErrors());
            }
        }
    }

    public function deleteFile()
{
    // Get the filename from the POST request
    $filename = $this->request->getPost('filename');

    // Get the user's session ID
    $userId = session()->get('loggedUserId');

    // Define the directory path
    $userDirectory = WRITEPATH . 'uploads/' . $userId . '/datasets';

    // Check if the file exists
    if (file_exists($userDirectory . '/' . $filename)) {
        // Delete the file
        unlink($userDirectory . '/' . $filename);
        // Redirect back to the file list page
        return redirect()->to('/dataset')->with('success', 'File deleted successfully.');
    } else {
        // Handle the case where the file doesn't exist
        return redirect()->to('/dataset')->with('error', 'File not found.');
    }
}

}
