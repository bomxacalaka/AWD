<?php

namespace App\Controllers;

use App\Controllers\BaseData;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home',
        ];
        // Create an instance of BaseData
        
        // Generate the full page with the home view
        return BaseData::getFullPage('home', $data);
    }
}
