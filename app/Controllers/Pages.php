<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\PageModel;
use App\Controllers\BaseData;
class Pages extends BaseController
{
        // Define the PageModel property
        protected $pageModel;

        public function __construct()
        {
            // Load the PageModel in the constructor
            $this->pageModel = new PageModel();
        }
    public function index()
    {
        return view('templates/header')
            . view('pages/home')
            . view('templates/footer');
    }

    public function view($page = 'about')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            // throw new PageNotFoundException($page);
            return view('pages/Error');
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }

    // Pages Controller

public function search()
{

    // In your controller constructor or method
$pageModel = new \App\Models\PageModel();


    $query = $this->request->getGet('q'); // Get the search query from the URL
    
    // Assuming you have a model method to search for pages
    $pages = $this->pageModel->searchPages($query);

    // Pass the search results to the view
    $data = [
        'query' => $query,
        'pages' => $pages
    ];

    // Load a view to display the search results
    return BaseData::getFullPage('pages/search_results', $data);
}

}