<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Upload extends Controller
{
    public function index()
    {
        return view('upload_form');
    }

    public function do_upload()
    {
        $this->CSRFProtection = false;
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move(WRITEPATH . 'uploads');
            echo 'File uploaded successfully.';
        } else {
            echo 'Error uploading file.';
        }
    }
}
