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

        return BaseData::getFullPage('dashboard/profile', $data);
    }
    public function upload()
    {
        helper(['form', 'url']);
    
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'profile_picture' => 'uploaded[profile_picture]|max_size[profile_picture,2048]|is_image[profile_picture]',
            ];
            $errors = [
                'profile_picture' => [
                    'uploaded' => 'Please select a valid image file to upload.',
                    'max_size' => 'The uploaded image exceeds the maximum allowed size of 1MB.',
                    'is_image' => 'Please upload a valid image file (JPG, PNG, GIF, etc.).',
                ],
            ];
            if ($this->validate($rules, $errors)) {
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
    
                return redirect()->to('dashboard/profile')->with('success', 'Profile picture uploaded successfully.');
            } else {
                return redirect()->to('dashboard/profile')->withInput()->with('error', $this->validator->listErrors());
            }
        }
    
        return BaseData::getFullPage('dashboard/upload', ['title' => 'Upload Profile Picture']);
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

    // Delete account
    public function deleteAccount()
    {
        $usersModel = new UserModel();
        $loggedUserId = session()->get('loggedUserId');
        $userInfo = $usersModel->find($loggedUserId);

        // Delete the user's profile picture
        $userDirectory = WRITEPATH . 'uploads/' . $loggedUserId;
        if (is_dir($userDirectory)) {
            $profilePicturePath = $userDirectory . '/pfp.webp';
            if (file_exists($profilePicturePath)) {
                unlink($profilePicturePath);
            }
            rmdir($userDirectory);
        }

        // Delete the user's account
        $usersModel->delete($loggedUserId);

        // Log the user out
        session()->destroy();

        return redirect()->to('/')->with('success', 'Your account has been deleted successfully.');
    }
    
}
