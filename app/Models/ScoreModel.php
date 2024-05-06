<?php

namespace App\Models;

use CodeIgniter\Model;

class ScoreModel extends Model
{
    protected $table = 'scores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['loss', 'accuracy', 'name', 'user_id', 'model_name', 'dataset_name', 'timestamp', 'epoch_number'];

    protected $useAutoIncrement = true;
    protected $useTimestamps = false; // Assuming you handle timestamps manually

    // You can define any custom methods or configurations here
}
