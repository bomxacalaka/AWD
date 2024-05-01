<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Controllers\BaseData;

class Dashboard extends BaseController
{

    public function __construct()
    {
        helper(['form', 'url']);
    }
    public function index()
    {
        $usersModel = new UserModel();
        $loggedUserId = session()->get('loggedUserId');
        $userInfo = $usersModel->find($loggedUserId);
        $data = [
            'title' => "Dashboard",
            'name' => $userInfo['firstname_usr'],
        ];

        // Load views with header and footer
        //return view('templates/header', $data)
        //    . view('dashboard/index', $data)
        //    . view('templates/footer', $data);

        return BaseData::getFullPage('dashboard/index', $data);

    }

    public function profile()
    {
        $usersModel = new UserModel();
        $loggedUserId = session()->get('loggedUserId');
        $userInfo = $usersModel->find($loggedUserId);
        $data = [
            'title' => "Profile",
            'name' => $userInfo['firstname_usr'],
            'userID' => $userInfo['id_usr'],
        ];

        // Load views with header and footer
        // return view('templates/header', $data)
        //     . view('dashboard/profile', $data)
        //     . view('templates/footer', $data);

        return BaseData::getFullPage('dashboard/profile', $data);
    }

    public function upload()
    {
        helper(['form', 'url']);
    
        $model = new UserModel();
    
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'profile_picture' => 'uploaded[profile_picture]|max_size[profile_picture,1024]|is_image[profile_picture]',
            ];
            if ($this->validate($rules)) {
                $profilePicture = $this->request->getFile('profile_picture');
                $newName = 'pfp.webp';
    
                // Create user-specific directory
                $userDirectory = WRITEPATH . 'uploads/' . session()->get('loggedUserId');
                if (!is_dir($userDirectory)) {
                    mkdir($userDirectory, 0700, true);
                }
    
                // Check if the user already has a profile picture and delete it
                $existingPicturePath = $userDirectory . '/' . $newName;
                if (file_exists($existingPicturePath)) {
                    unlink($existingPicturePath);
                }
    
                // Move the uploaded file to the user's directory
                $profilePicture->move($userDirectory, $newName);
    
                $data = [
                    'ppicture_usr' => $newName
                ];
                $model->update(session()->get('loggedUserId'), $data);
    
                return redirect()->to('dashboard/profile')->with('success', 'Profile picture uploaded successfully.');
            } else {
                return redirect()->to('dashboard/profile')->withInput()->with('error', $this->validator->listErrors());
            }
        }
    
        return BaseData::getFullPage('dashboard/upload', ['title' => 'Upload Profile Picture']);
    }
    

    // Default profile picture
    public function pfp()
    {
        $path = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/pfp.webp';
        $defaultPath = WRITEPATH . 'uploads/default_pfp.svg';
    
        if (file_exists($path)) {
            // Set appropriate headers
            $this->response->setHeader('Content-Type', 'image/webp');
            $this->response->setHeader('Content-Length', filesize($path));
            $content = file_get_contents($path);
        } else {
            $this->response->setHeader('Content-Type', 'image/svg+xml');
            $this->response->setHeader('Content-Length', filesize($defaultPath));
            $content = file_get_contents($defaultPath);
        }
    
        // Echo the image content after setting headers
        echo $content;
    }

    public function getUserProfilePicture($userId)
    {
        // Ensure that the requested user ID matches the logged-in user's ID (or implement your authentication logic)
        // For security reasons, you should verify that the user has permission to access the picture
        
        // Assuming the user's pictures are stored in the 'writable/uploads' directory
        $filePath = WRITEPATH . 'uploads/' . $userId . '/pfp.webp';
        
        // Check if the file exists
        if (file_exists($filePath)) {
            // Set appropriate headers
            header('Content-Type: ' . mime_content_type($filePath));
            readfile($filePath);
            exit;
        } else {
            // Handle file not found
            $filePath = WRITEPATH . 'uploads/default_pfp.png';
            header('Content-Type: ' . mime_content_type($filePath));
            readfile($filePath);
            exit;
        }
    }
    
}
