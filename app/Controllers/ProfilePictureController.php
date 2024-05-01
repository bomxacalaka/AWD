<?php
// Controller: ProfilePictureController.php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProfilePictureModel;
use App\Models\UserModel;
use App\Controllers\BaseData;

class ProfilePictureController extends Controller
{

    public function __construct()
    {
        helper(['form', 'url']);
    }
    public function index()
    {
        $data = [
            'title' => 'Upload Profile Picture',
        ];
        return BaseData::getFullPage('dashboard/upload', $data);
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
                // $newName = $profilePicture->getRandomName();
                $newName = 'pfp.webp';
    
                // Create user-specific directory
                $userDirectory = WRITEPATH . 'uploads/' . session()->get('loggedUserId');
                if (!is_dir($userDirectory)) {
                    mkdir($userDirectory, 0700, true);
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
    
        return view('upload');
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
            return $this->response->setStatusCode(404);
        }
    }
}