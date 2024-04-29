<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Python extends Controller
{
    public function runPython()
    {
        $condaEnv = 'tf'; // Replace 'your_conda_env' with the name of your Conda environment
        $pythonScript = '/var/www/html/AWD/scripts/script_1.py'; // Replace 'path_to_your_python_script.py' with the path to your Python script

        // Construct the command to activate the Conda environment and run the Python script
        $command = "/var/www/html/AWD/envs/bin/python3.12 /var/www/html/AWD/scripts/script_1.py";

        // Execute the command
        $output = shell_exec($command);

        // // Output the result if needed
        // echo $output;

        // Decode the JSON output into a PHP associative array
        $outputArray = json_decode($output, true);


        return $this->response->setJSON(['data' => $outputArray]);
    }
}
