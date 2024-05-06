<?php

namespace App\Controllers;

use App\Models\ScoreModel;
use App\Controllers\BaseData;

class Leaderboard extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        // Get the sort parameter from the query string
        $sort = $this->request->getGet('sort');

        // Determine the default sort column and order
        $defaultSort = 'accuracy';
        $defaultOrder = 'DESC';

        // Define the allowed columns for sorting
        $allowedColumns = ['name', 'loss', 'accuracy', 'model_name', 'dataset_name', 'model_timestamp'];

        // Validate and sanitize the sort parameter
        $sort = in_array($sort, $allowedColumns) ? $sort : $defaultSort;

        // Get the sort order (ASC or DESC)
        $order = ($this->request->getGet('order') === 'asc') ? 'ASC' : $defaultOrder;

        // Load the ScoreModel
        $ScoreModel = new ScoreModel();

        // Fetch scores from the database, sorted by the selected column and order
        $data = [
            'title' => "Leaderboard",
            'scores' => $ScoreModel->orderBy($sort, $order)->findAll(),
            'sort' => $sort, // Pass $sort to the view
            'order' => $order // Pass $order to the view
        ];

        // Pass data to the view
        return BaseData::getFullPage('published/leaderboard', $data);
    }
}
