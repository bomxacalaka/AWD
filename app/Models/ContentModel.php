<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentModel extends Model
{
    // Title and content
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content'];

}



