<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Download extends Controller
{
    public function downloadFile()
    {
        $filePath = '/var/www/html/AWD/writable/uploads/rnn_model_20e.zip'; // Adjust the path to your file

        return $this->response->download($filePath, null, true);
    }
}
