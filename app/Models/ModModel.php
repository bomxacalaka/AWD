<?php

namespace App\Models;

use CodeIgniter\Model;

class ModModel extends Model
{
    protected $table = 'mods';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'forge_version_id'];
}
