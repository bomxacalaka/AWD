<?php

namespace App\Controllers;

use App\Controllers\BaseData;

class Model extends BaseController
{

    public function index()
    {
        return BaseData::getFullPage('models/models');
    }
    public function view( $page = 'index')
    {
        if (! is_file(APPPATH . 'Views/models/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            // throw new PageNotFoundException($page);
            return view('pages/Error');
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
            . view('models/' . $page)
            . view('templates/footer');
    }

    public function create()
    {
        return BaseData::getFullPage('models/create');
    }

    public function test()
    {
        return BaseData::getFullPage('models/test');
    }
}
