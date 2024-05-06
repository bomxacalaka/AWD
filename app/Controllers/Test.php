<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseData;
use CodeIgniter\Controller;
use App\Models\ScoreModel;

class Test extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        // Get the user's session ID
        $userId = session()->get('loggedUserId');

        // Define the directory path
        $userDirectory = WRITEPATH . 'uploads/' . $userId;
        $modelDirectory = $userDirectory . '/models';
        $datasetDirectory = $userDirectory . '/datasets';
        $scriptDirectory = '../scripts';
        

        $UserModel = new UserModel();
        $ScoreModel = new ScoreModel();
        $data = [
            'title' => "Test Page",
            'name' => $UserModel->find($userId)['firstname_usr'],
            'userID' => $userId,
        ];

        $results = [1,2,3];

        // Check if the directory exists
        if (is_dir($modelDirectory) && is_dir($datasetDirectory)) {
            // List all files in the directory
            $models = array_diff(scandir($modelDirectory), array('..', '.'));
            $datasets = array_diff(scandir($datasetDirectory), array('..', '.'));
            $scripts = array_diff(scandir($scriptDirectory), array('..', '.'));

            // You can now do whatever you want with the $files array
            // For example, you can pass it to a view to display the list to the user
            $data = [
                'title' => 'Test Models',
                'models' => $models,
                'datasets' => $datasets,
                'results' => $results,
                'scripts' => $scripts
            ];
            return BaseData::getFullPage('test/show', $data);
        } else {
            // Handle the case where the directory doesn't exist
            $data = [
                'title' => 'Test Page',
                'models' => ["No models found"],
                'datasets' => ["No datasets found"],
                'results' => ["No results found"],
                'scripts' => ["No scripts found"]
            ];
            return BaseData::getFullPage('test/show', $data);
        }
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
        $ScoreModel->insert([
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
    

}
