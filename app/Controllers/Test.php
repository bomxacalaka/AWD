<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseData;
use CodeIgniter\Controller;
use App\Models\ScoreModel;

class Test extends BaseController
{
    protected $session;
    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    public function index()
    {
        // Get the user's session ID
        $userId = session()->get('loggedUserId');
    
        // Define the directory paths
        $userDirectory = WRITEPATH . 'uploads/' . $userId;
        $modelDirectory = $userDirectory . '/models';
        $datasetDirectory = $userDirectory . '/datasets';
        $scriptDirectory = '../scripts';
    
        // Check if the directories exist, create them if they don't
        if (!is_dir($modelDirectory)) {
            mkdir($modelDirectory, 0700, true);
        }
        if (!is_dir($datasetDirectory)) {
            mkdir($datasetDirectory, 0700, true);
        }
    
        // Initialize arrays for models, datasets, and scripts
        $models = [];
        $datasets = [];
        $scripts = [];
    
        // Get the list of files in each directory
        if (is_dir($modelDirectory)) {
            $models = array_diff(scandir($modelDirectory), array('..', '.'));
        }
        if (is_dir($datasetDirectory)) {
            $datasets = array_diff(scandir($datasetDirectory), array('..', '.'));
        }
        if (is_dir($scriptDirectory)) {
            $scripts = array_diff(scandir($scriptDirectory), array('..', '.'));
        }
    
        // Check if directories are empty
        if (empty($models)) {
            $models = ['No models found'];
        } 
        if (empty($datasets)) {
            $datasets = ['No datasets found'];
        }
        if (empty($scripts)) {
            $scripts = ['No scripts found'];
        }
    
        // Construct the data array
        $data = [
            'title' => "Test Page",
            'name' => (new UserModel())->find($userId)['firstname_usr'],
            'userID' => $userId,
            'models' => $models,
            'datasets' => $datasets,
            'scripts' => $scripts,
        ];
    
        return BaseData::getFullPage('test/show', $data);
    }
    

    public function run()
    {
        // $request = \Config\Services::request();
        $datasets = $this->request->getGet('datasets');
        $models = $this->request->getGet('models');
        $script = $this->request->getGet('script');
        // $script = $this->request->getGet('script');
        // $test = $this->request->getGet('test');
        // $file = $this->request->getGet('file');

        
        $data = [
            'datasets' => $datasets,
            'models' => $models,
            'script' => $script,
            'test' => "",
            'file' => "/var/www/html/AWD/writable/uploads/0/default_config.json",
            'class_names_path' => '/var/www/html/AWD/writable/uploads/0/class_names.txt'
        ];
        
        // Find model path
        $modelPath = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/models/' . $data['models'];
        // Find dataset path
        $datasetPath = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/datasets/' . $data['datasets'];
        
        $data['model'] = $modelPath;
        $data['dataset'] = $datasetPath;
        
        // Convert JSON data from an array to a string
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        // Write in the file
        $fp = fopen($data['file'], 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
        
        $command = "/var/www/html/AWD/envs/bin/python3.12 /var/www/html/AWD/scripts/" . $data['script'] . " --file " . $data['file'];
        
        // return $this->response->setJSON(['command' => $command]);
        // Execute the command
        $output = shell_exec($command);

        // Decode the JSON output into a PHP associative array
        $outputArray = json_decode($output, true);

        // Return the response
        return $this->response->setJSON($outputArray);
    }

    public function share()
    {
        // Get the user's session ID
        $userId = session()->get('loggedUserId');

        $UserModel = new UserModel();
        $ScoreModel = new ScoreModel();

        $datasets = $this->request->getGet('datasets');
        $models = $this->request->getGet('models');
        $scripts = $this->request->getGet('scripts');
        $results = $this->request->getGet('results');

        // results ,loss:0.69,accuracy:0.45
        // Remove leading comma if present
        $string = ltrim($results, ',');

        // Split the string into key-value pairs
        $pairs = explode(',', $string);

        // Initialize an empty array to store the key-value pairs
        $data = [];

        // Loop through each pair
        foreach ($pairs as $pair) {
            // Split each pair into key and value
            list($key, $value) = explode(':', $pair);
            // Add key-value pair to the data array
            $data[$key] = $value;
        }

        // Insert the results into the database
        $ScoreModel->save([
            'loss' => $data['loss'] ?? -69,
            'accuracy' => $data['accuracy'] ?? -69,
            'name' => $UserModel->find($userId)['firstname_usr'] ?? 'Unknown',
            'user_id' => $userId,
            'model_name' => $models ?? 'Unknown',
            'dataset_name' => $datasets ?? 'Unknown',
            'epoch_number' => $data['epoch'] ?? -69
        ]);

        // Return the response
        return $this->response->setJSON(['status' => 'success', 'message' => 'Results shared successfully', 'datasets' => $datasets, 'models' => $models, 'scripts' => $scripts, 'results' => $data]);
    }


    public function quick()
    {
        $model = $this->request->getGet('model') ?? 'default';
        $userId = $this->request->getGet('user_id') ?? 0;

        session()->set('model', $model);
        session()->set('from_user_id', $userId);

        $data = [
            'title' => 'Quick Test',
            'model' => $model,
            'user_id' => $userId,
        ];
        return BaseData::getFullPage('test/quick', ['data' => $data]);
    }

    public function quick_pic2()
        {
        helper(['form', 'url']);

        $model = new UserModel();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'profile_picture' => 'max_size[profile_picture,100000]',
            ];
            if ($this->validate($rules)) {
                $profilePicture = $this->request->getFile('profile_picture');
                // $newName = $profilePicture->getRandomName();
                $newName = 'pfp.png';

                // Create user-specific directory
                $quickTest = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/quick_test';
                if (!is_dir($quickTest)) {
                    mkdir($quickTest, 0700, true);
                }

                // Delete the existing test image
                $existingImage = $quickTest . '/pfp.png';
                if (file_exists($existingImage)) {
                    unlink($existingImage);
                }

                // Move the uploaded file to the user's directory
                $profilePicture->move($quickTest, $newName);

                $data = [
                    'ppicture_usr' => $newName
                ];
                $model->update(session()->get('loggedUserId'), $data);


                return redirect()->to('test/quick')->with('success', 'Profile picture uploaded successfully.')->with('model', $model)->with('from_user_id', session()->get('from_user_id'));
            } else {
                return redirect()->to('test/quick')->withInput()->with('error', $this->validator->listErrors());
            }
        }

        return view('upload');
    }
    public function quick_pic()
        {
        helper(['form', 'url']);

        $model = new UserModel();

        if ($this->request->getMethod() === 'post') {
            $profilePicture = $this->request->getFile('profile_picture');
        
            // Debugging: Log the $profilePicture variable
            if ($profilePicture === null) {
                // Log error or return error response
                return $this->response->setJSON(['status' => 'error', 'message' => 'No file uploaded.']);
            }

                // $profilePicture = $this->request->getFile('profile_picture');
                // $newName = $profilePicture->getRandomName();
                $newName = 'pfp.png';

                // Create user-specific directory
                $quickTest = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/quick_test';
                if (!is_dir($quickTest)) {
                    mkdir($quickTest, 0700, true);
                }

                // Delete the existing test image
                $existingImage = $quickTest . '/pfp.png';
                if (file_exists($existingImage)) {
                    unlink($existingImage);
                }

                // Move the uploaded file to the user's directory
                $profilePicture->move($quickTest, $newName);

                $data = [
                    'ppicture_usr' => $newName
                ];
                $model->update(session()->get('loggedUserId'), $data);


                return $this->response->setJSON(['status' => 'success', 'message' => 'Profile picture uploaded successfully.']);

        }

        return view('upload');
    }


    public function getPic($userId)
    {
        // Ensure that the requested user ID matches the logged-in user's ID (or implement your authentication logic)
        // For security reasons, you should verify that the user has permission to access the picture
        
        
        // Assuming the user's pictures are stored in the 'writable/uploads' directory
        $filePath = WRITEPATH . 'uploads/' . $userId . '/quick_test/pfp.png';
        
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

    public function predict2()
    {
        $model = session()->get('model');
        $userId = session()->get('from_user_id');

        // Find model path
        // $modelPath = WRITEPATH . 'uploads/' . $userId . '/models/' . $model;
        $modelPath = "/var/www/html/AWD/scripts/Models/202405120247/model.onnx";
        $img_path = WRITEPATH . 'uploads/' . 13 . '/quick_test/pfp.png';

        $data = [
            'title' => 'Predict',
            'models' => $model,
            'user_id' => $userId,
            'file' => "/var/www/html/AWD/writable/uploads/0/default_config.json",
            'test' => "1",
            'script' => "script_2.py",
            'img_path' => $img_path,
            'model_path' => $modelPath,
            'class_names_path' => '/var/www/html/AWD/writable/uploads/0/class_names.txt',
            'python_path' => '/home/jd/miniconda3/envs/pytorch/bin/python3'
        ];

        // Convert JSON data from an array to a string
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        // Write in the file
        $fp = fopen($data['file'], 'w');
        fwrite($fp, $jsonString);
        fclose($fp);

        $command = $data['python_path'] . " /var/www/html/AWD/scripts/" . $data['script'] . " --file " . $data['file'];
        // $command = "/var/www/html/AWD/envs/bin/python3.12 /var/www/html/AWD/scripts/" . $data['script'] . " --file " . $data['file'];

        // Execute the command
        $output = shell_exec($command);

        // Decode the JSON output into a PHP associative array
        $outputArray = json_decode($output, true);

        // Array for test
        // $outputArray['test'] = $command;

        // Return the response
        return $this->response->setJSON(['output' => $outputArray, 'message' => 'success', 'command' => $command]);
    }


    // // back button that sends back to whatever page was back
    // public function back()
    // {
    //     $newdata = [
    //         'username'  => 'johndoe',
    //         'email'     => 'johndoe@some-site.com',
    //         'logged_in' => TRUE
    // ];

    // $this->session->set($newdata); // setting session data


    // echo $this->session->get("username");
    // }



    
    public function predict()
    {
        // $request = \Config\Services::request();
        $datasets = $this->request->getGet('datasets') ?? 'pfp.png';
        $models = $this->request->getGet('models') ?? 'model.onnx';
        $script = $this->request->getGet('script') ?? 'handwriting.py';
        // $script = $this->request->getGet('script');
        // $test = $this->request->getGet('test');
        // $file = $this->request->getGet('file');

        
        $data = [
            'datasets' => $datasets,
            'models' => $models,
            'script' => $script,
            'test' => "",
            'file' => "/var/www/html/AWD/writable/uploads/0/default_config.json",
            'class_names_path' => '/var/www/html/AWD/writable/uploads/0/class_names.txt'
        ];
        
        // Find model path
        $modelPath = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/models/' . $data['models'];
        // Find dataset path
        $datasetPath = WRITEPATH . 'uploads/' . session()->get('loggedUserId') . '/quick_test/' . $data['datasets'];
        
        $data['model'] = $modelPath;
        $data['dataset'] = $datasetPath;
        
        // Convert JSON data from an array to a string
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        // Write in the file
        $fp = fopen($data['file'], 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
        
        $command = "/var/www/html/AWD/envs/bin/python3.12 /var/www/html/AWD/scripts/" . $data['script'] . " --file " . $data['file'];
        
        // return $this->response->setJSON(['command' => $command]);
        // Execute the command
        $output = shell_exec($command);

        // Decode the JSON output into a PHP associative array
        $outputArray = json_decode($output, true);

        // Return the response
        return $this->response->setJSON(['output' => $outputArray, 'status' => 'success']);
    }
}
