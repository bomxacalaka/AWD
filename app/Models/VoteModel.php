<?php

namespace App\Models;

use CodeIgniter\Model;

class VoteModel extends Model
{
    protected $table = 'votes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['mod_id', 'created_at', 'updated_at'];
}
