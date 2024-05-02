<?php
// app/Models/PageModel.php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'pages'; // Assuming your pages table is named 'pages'
    protected $primaryKey = 'id'; // Assuming 'id' is the primary key column

    protected $allowedFields = ['title', 'content']; // List of fields that can be mass-assigned

    /**
     * Search for pages based on a query string.
     *
     * @param string $query
     * @return array Array of page records matching the query
     */
    public function searchPages($query)
    {
        return $this->like('title', $query)
                    ->orLike('content', $query)
                    ->findAll();
    }
}
