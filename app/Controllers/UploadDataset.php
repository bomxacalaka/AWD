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

        if (!is_dir($userDirectory)) {
            mkdir($userDirectory, 0700, true);
        }

        // Check if the directory exists
        if (is_dir($userDirectory)) {
            // List all files in the directory
            $files = array_diff(scandir($userDirectory), array('.', '..'));

            // Get the size of each file in mb
            foreach ($files as $key => $file) {
                $files[$key] = [
                    'name' => $file,
                    'size' => round(filesize($userDirectory . '/' . $file) / 1024 / 1024, 2),
                ];
            }

            // You can now do whatever you want with the $files array
            // For example, you can pass it to a view to display the list to the user
            return BaseData::getFullPage('dataset/list', ['files' => $files, 'data' => $data]);
        } else {
            // Handle the case where the directory doesn't exist
            return BaseData::getFullPage('dataset/list', ['files' => ["No files found"], 'data' => $data]);
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

    public function huggingface()
    {
        $data = [
            'title' => "Hugging Face Datasets",
        ];
        return BaseData::getFullPage('dataset/huggindownload', ['data' => $data]);
    }
    public function downloadFromHuggingface()
    {
        // Get the user's session ID
        $userId = session()->get('loggedUserId');
    
        // Define the directory path
        $userDirectory = WRITEPATH . 'uploads/' . $userId . '/datasets';
    
        // Check if the directory exists
        if (!is_dir($userDirectory)) {
            mkdir($userDirectory, 0700, true);
        }
    
        // URL of the dataset to download
        $dataset = $this->request->getGet('dataset');
        $url = 'https://datasets-server.huggingface.co/parquet?dataset=' . $dataset;
    
        // Initialize cURL session
        $curl = curl_init();
    
        // Set cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'My-User-Agent',
            CURLOPT_FOLLOWLOCATION => true, // Follow redirections
        ]);
    
        // Execute cURL request
        $response = curl_exec($curl);
    
        // Check for cURL errors
        if (curl_error($curl)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'cURL Error: ' . curl_error($curl)]);
        }
    
        // Close cURL session
        curl_close($curl);
    
        // Decode JSON response
        $data = json_decode($response, true);
    
        // Check if dataset info is available
        if (!isset($data['parquet_files'][0]['url'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Dataset information not found.']);
        }
    
        // Download link and filename
        $downloadLink = $data['parquet_files'][0]['url'];
    
        // Initialize cURL session for downloading the file
        $curl = curl_init();
    
        // Set cURL options for downloading the file
        curl_setopt_array($curl, [
            CURLOPT_URL => $downloadLink,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'My-User-Agent',
            CURLOPT_FOLLOWLOCATION => true, // Follow redirections
        ]);
    
        // Execute cURL request to download the file
        $file = curl_exec($curl);
    
        // Check for cURL errors during file download
        if (curl_error($curl)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to download dataset file: ' . curl_error($curl)]);
        }
    
        // Close cURL session for downloading the file
        curl_close($curl);
    
        // Save the file
        // Replace / from $database
        $filename = str_replace('/', '_', $dataset) . '_' . basename($downloadLink); // Get filename from URL
        file_put_contents($userDirectory . '/' . $filename, $file);
    
        // Return success response
        return $this->response->setJSON(['status' => 'success', 'message' => 'Dataset downloaded successfully.', 'filename' => $filename]);
    }
    
    
}
