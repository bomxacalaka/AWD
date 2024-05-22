<?php

namespace App\Models;

use CodeIgniter\Model;

class ForgeVersionModel extends Model
{
    protected $table = 'forge_versions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['version'];
}
