<?php

namespace App\Models;

use CodeIgniter\Model;

class PageViewCounter extends Model
{
    protected $table      = 'page_view_counter';
    protected $primaryKey = 'id';

    protected $allowedFields = ['page', 'views'];
}
