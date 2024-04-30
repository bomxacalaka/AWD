<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'user_usr';
    protected $primaryKey = 'id_usr';
    protected $allowedFields = ['firstname_usr', 'password_usr', 'email_usr'];
}